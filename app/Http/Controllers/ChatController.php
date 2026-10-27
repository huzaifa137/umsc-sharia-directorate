<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Services\AccessControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    /**
     * The chat page itself. Everything else is loaded via AJAX from here.
     */
    public function index()
    {
        return view('chat.index');
    }

    /**
     * Conversation list for the sidebar (direct chats + groups the current
     * user belongs to), each with a last-message preview and unread count.
     * ?type=direct|group filters the tab; omit for "All".
     */
    public function conversations(Request $request)
    {
        $me = AccessControl::user();
        $type = $request->query('type');

        $conversations = $me->conversations()
            ->with([
                'latestMessage.sender',
                'users' => fn ($q) => $q->where('users.id', '!=', $me->id),
            ])
            ->when($type, fn ($q) => $q->where('type', $type))
            ->get()
            ->sortByDesc(fn ($c) => optional($c->latestMessage)->created_at ?? $c->created_at)
            ->values()
            ->map(function ($conversation) use ($me) {
                $pivot = $conversation->pivot;

                $unread = Message::where('conversation_id', $conversation->id)
                    ->where('sender_id', '!=', $me->id)
                    ->when($pivot->last_read_at, fn ($q) => $q->where('created_at', '>', $pivot->last_read_at))
                    ->count();

                $other = $conversation->type === 'direct' ? $conversation->users->first() : null;

                return [
                    'id' => $conversation->id,
                    'type' => $conversation->type,
                    'name' => $conversation->type === 'group' ? $conversation->name : ($other?->full_name ?? 'Unknown user'),
                    'subtitle' => $conversation->type === 'group'
                        ? $conversation->users()->count() . ' members'
                        : ($other?->role_name ?? ''),
                    'avatar' => $conversation->type === 'group'
                        ? $this->avatarUrl($conversation->avatar)
                        : $this->avatarUrl($other?->profile_photo),
                    'last_message' => $conversation->latestMessage
                        ? ($conversation->latestMessage->body ?? '📎 Attachment')
                        : 'Say hello 👋',
                    'last_message_at' => $conversation->latestMessage?->created_at?->diffForHumans(null, true),
                    'unread' => $unread,
                ];
            });

        return response()->json(['status' => true, 'conversations' => $conversations->values()]);
    }

    /**
     * Full message thread for a conversation. Marks it read as a side effect.
     */
    public function messages(Conversation $conversation)
    {
        $me = AccessControl::user();
        $this->authorizeParticipant($conversation, $me);

        $messages = $conversation->messages()->with('sender')->get()->map(fn ($m) => $this->formatMessage($m));

        $this->markRead($conversation, $me);

        $other = $conversation->type === 'direct' ? $conversation->otherParticipant($me->id) : null;

        return response()->json([
            'status' => true,
            'messages' => $messages,
            'header' => [
                'name' => $conversation->type === 'group' ? $conversation->name : ($other?->full_name ?? 'Unknown user'),
                'subtitle' => $conversation->type === 'group'
                    ? $conversation->users()->count() . ' members'
                    : ($other?->role_name ?? ''),
                'avatar' => $conversation->type === 'group'
                    ? $this->avatarUrl($conversation->avatar)
                    : $this->avatarUrl($other?->profile_photo),
                'type' => $conversation->type,
            ],
        ]);
    }

    /**
     * Contact info (direct chats) or group info (group chats) — shown when
     * the person taps the avatar/name in the chat header, WhatsApp-style.
     */
    public function profile(Conversation $conversation)
    {
        $me = AccessControl::user();
        $this->authorizeParticipant($conversation, $me);

        if ($conversation->type === 'direct') {
            $other = $conversation->otherParticipant($me->id);
            abort_unless($other, 404);

            return response()->json([
                'status' => true,
                'type' => 'direct',
                'user' => [
                    'name' => $other->full_name,
                    'role' => $other->role_name,
                    'avatar' => $this->avatarUrl($other->profile_photo),
                    'email' => $other->email,
                    'phone' => $other->phonenumber,
                    'district' => $other->district,
                    'mosque' => $other->mosque_name,
                ],
            ]);
        }

        $members = $conversation->users()->get()->map(fn ($u) => [
            'id' => $u->id,
            'name' => $u->full_name,
            'role' => $u->role_name,
            'avatar' => $this->avatarUrl($u->profile_photo),
            'is_admin' => (bool) $u->pivot->is_admin,
        ]);

        return response()->json([
            'status' => true,
            'type' => 'group',
            'group' => [
                'name' => $conversation->name,
                'avatar' => $this->avatarUrl($conversation->avatar),
                'members_count' => $members->count(),
            ],
            'members' => $members,
        ]);
    }

    /**
     * Lightweight polling endpoint — only messages newer than `since`
     * (unix timestamp). The chat window calls this every few seconds
     * instead of holding a websocket connection open, so it works on
     * plain shared hosting with no extra services running.
     */
    public function poll(Request $request, Conversation $conversation)
    {
        $me = AccessControl::user();
        $this->authorizeParticipant($conversation, $me);

        $since = $request->query('since');

        $query = $conversation->messages()->with('sender');
        if ($since) {
            $query->where('created_at', '>', date('Y-m-d H:i:s', (int) $since));
        }

        $messages = $query->get()->map(fn ($m) => $this->formatMessage($m));

        if ($messages->isNotEmpty()) {
            $this->markRead($conversation, $me);
        }

        return response()->json(['status' => true, 'messages' => $messages, 'now' => now()->timestamp]);
    }

    public function store(Request $request, Conversation $conversation)
    {
        $me = AccessControl::user();
        $this->authorizeParticipant($conversation, $me);

        $data = $request->validate([
            'body' => 'nullable|string|max:5000',
            'attachment' => 'nullable|file|max:25600', // 25MB — covers short voice notes and video clips
        ]);

        if (empty($data['body']) && !$request->hasFile('attachment')) {
            return response()->json(['status' => false, 'message' => 'Message cannot be empty.'], 422);
        }

        $attachmentPath = null;
        $attachmentType = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentPath = $file->store('chat/attachments', 'public');
            $mime = $file->getMimeType();

            $attachmentType = match (true) {
                str_starts_with($mime, 'image/') => 'image',
                str_starts_with($mime, 'video/') => 'video',
                str_starts_with($mime, 'audio/') => 'audio',
                default => 'file',
            };
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $me->id,
            'body' => $data['body'] ?? null,
            'attachment_path' => $attachmentPath,
            'attachment_type' => $attachmentType,
        ]);

        $conversation->touch();
        $this->markRead($conversation, $me);

        return response()->json(['status' => true, 'message' => $this->formatMessage($message->load('sender'))]);
    }

    /**
     * Search staff to start a chat with / add to a group.
     */
    public function searchUsers(Request $request)
    {
        $me = AccessControl::user();
        $term = trim((string) $request->query('q'));

        $users = User::where('id', '!=', $me->id)
            ->where('account_status', 10) // active only
            ->when($term !== '', function ($q) use ($term) {
                $q->where(function ($q) use ($term) {
                    $q->where('firstname', 'like', "%{$term}%")
                        ->orWhere('lastname', 'like', "%{$term}%")
                        ->orWhere('username', 'like', "%{$term}%");
                });
            })
            ->orderBy('firstname')
            ->limit(30)
            ->get()
            ->map(fn ($u) => [
                'id' => $u->id,
                'name' => $u->full_name,
                'role' => $u->role_name,
                'avatar' => $this->avatarUrl($u->profile_photo),
            ]);

        return response()->json(['status' => true, 'users' => $users]);
    }

    /**
     * Find or create a direct (1-on-1) conversation with the given user.
     */
    public function startDirect(Request $request)
    {
        $me = AccessControl::user();

        $data = $request->validate(['user_id' => 'required|exists:users,id']);

        if ((int) $data['user_id'] === (int) $me->id) {
            return response()->json(['status' => false, 'message' => 'You cannot start a chat with yourself.'], 422);
        }

        $existing = Conversation::where('type', 'direct')
            ->whereHas('users', fn ($q) => $q->where('users.id', $me->id))
            ->whereHas('users', fn ($q) => $q->where('users.id', $data['user_id']))
            ->first();

        if ($existing) {
            return response()->json(['status' => true, 'conversation_id' => $existing->id]);
        }

        $conversation = Conversation::create(['type' => 'direct', 'created_by' => $me->id]);
        $conversation->users()->attach([
            $me->id => ['joined_at' => now()],
            $data['user_id'] => ['joined_at' => now()],
        ]);

        return response()->json(['status' => true, 'conversation_id' => $conversation->id]);
    }

    /**
     * Create a group conversation.
     */
    public function createGroup(Request $request)
    {
        $me = AccessControl::user();

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'integer|exists:users,id',
        ]);

        $conversation = Conversation::create([
            'type' => 'group',
            'name' => $data['name'],
            'created_by' => $me->id,
        ]);

        $memberIds = collect($data['user_ids'])->reject(fn ($id) => (int) $id === (int) $me->id)->unique();

        $attach = [$me->id => ['joined_at' => now(), 'is_admin' => true]];
        foreach ($memberIds as $id) {
            $attach[$id] = ['joined_at' => now(), 'is_admin' => false];
        }

        $conversation->users()->attach($attach);

        return response()->json(['status' => true, 'conversation_id' => $conversation->id]);
    }

    /**
     * Badge count for the sidebar "Chat" menu item.
     */
    public function unreadCount()
    {
        $me = AccessControl::user();

        $count = DB::table('conversation_participants as cp')
            ->join('messages as m', 'm.conversation_id', '=', 'cp.conversation_id')
            ->where('cp.user_id', $me->id)
            ->where('m.sender_id', '!=', $me->id)
            ->where(function ($q) {
                $q->whereColumn('m.created_at', '>', 'cp.last_read_at')
                    ->orWhereNull('cp.last_read_at');
            })
            ->distinct()
            ->count('m.id');

        return response()->json(['status' => true, 'count' => $count]);
    }

    /**
     * Streams a message's attachment straight from the 'public' disk. This
     * replaces the old asset('storage/...') symlink-based URL — Windows
     * dev environments frequently end up with a broken or permission-
     * restricted `public/storage` junction, which silently 403s every file
     * request. Serving through a real route sidesteps that entirely, and
     * as a bonus actually checks the requester is a participant in the
     * conversation before handing over what may be a sensitive Sharia case
     * attachment, which the old public symlink URL never did.
     */
    public function attachment(Message $message)
    {
        $me = AccessControl::user();
        $this->authorizeParticipant($message->conversation, $me);

        abort_unless($message->attachment_path, 404);

        $disk = Storage::disk('public');
        abort_unless($disk->exists($message->attachment_path), 404);

        return $disk->response($message->attachment_path);
    }

    /**
     * Streams a profile/group avatar from the 'public' disk, for the same
     * symlink-avoidance reason as attachment() above. Avatars aren't
     * sensitive case data, so this only requires the requester to be a
     * logged-in staff member (already enforced by the AdminAuth + chat.view
     * middleware this route sits behind) — no per-conversation check.
     */
    public function avatar(Request $request)
    {
        $path = $request->query('path');
        abort_if(!$path || str_contains($path, '..'), 404);

        $disk = Storage::disk('public');
        abort_unless($disk->exists($path), 404);

        return $disk->response($path);
    }

    protected function avatarUrl(?string $path): ?string
    {
        return $path ? route('chat.avatar', ['path' => $path]) : null;
    }

    protected function formatMessage(Message $m): array
    {
        return [
            'id' => $m->id,
            'sender_id' => $m->sender_id,
            'sender_name' => $m->sender->full_name,
            'body' => $m->body,
            'attachment' => $m->attachment_path ? route('chat.attachment', $m->id) : null,
            'attachment_type' => $m->attachment_type,
            'created_at' => $m->created_at->format('g:i A'),
            'created_ts' => $m->created_at->timestamp,
        ];
    }

    protected function markRead(Conversation $conversation, User $user): void
    {
        DB::table('conversation_participants')
            ->where('conversation_id', $conversation->id)
            ->where('user_id', $user->id)
            ->update(['last_read_at' => now()]);
    }

    protected function authorizeParticipant(Conversation $conversation, User $user): void
    {
        abort_unless(
            $conversation->users()->where('users.id', $user->id)->exists(),
            403,
            'You are not part of this conversation.'
        );
    }
}