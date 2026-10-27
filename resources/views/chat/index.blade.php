{{--
    resources/views/chat/index.blade.php
    Confirmed against your nikah-applications view: layout is 'layouts.app',
    and everything (including the page's own <script>) lives inside a single
    @section('content') ... @endsection block.
--}}
@extends('layouts.app')

@section('content')
<style>
    :root { --chat-primary: #008F4C; --chat-primary-light: rgba(0,143,76,0.12); }
    .chat-app { height: calc(100vh - 180px); min-height: 560px; overflow: hidden; }
    .chat-app-inner { display: flex; height: 100%; }

    .chat-list-pane { width: 340px; flex-shrink: 0; border-right: 1px solid #eee; display: flex; flex-direction: column; }
    .chat-list-header { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.25rem 0.5rem; }
    .btn-new-chat { border: none; background: var(--chat-primary); color: #fff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
    .chat-list-tabs { display: flex; gap: .5rem; padding: 0.5rem 1.25rem; }
    .chat-tab { border: none; background: transparent; padding: .35rem .9rem; border-radius: 20px; font-size: .82rem; color: #6c757d; }
    .chat-tab.active { background: var(--chat-primary-light); color: var(--chat-primary); font-weight: 600; }
    .chat-list-search { position: relative; margin: 0.25rem 1.25rem 0.75rem; }
    .chat-list-search i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #adb5bd; }
    .chat-list-search input { width: 100%; padding: .5rem .75rem .5rem 2.2rem; border-radius: 20px; border: 1px solid #e9ecef; background: #f8f9fa; font-size: .85rem; }
    .chat-list-search input:focus { outline: none; border-color: var(--chat-primary); }
    .chat-list-scroll { flex: 1; overflow-y: auto; padding-bottom: 1rem; }
    .chat-list-item { display: flex; gap: .65rem; padding: .65rem 1.25rem; cursor: pointer; border-left: 3px solid transparent; }
    .chat-list-item:hover { background: #f8f9fa; }
    .chat-list-item.active { background: var(--chat-primary-light); border-left-color: var(--chat-primary); }
    .chat-list-item-body { flex: 1; min-width: 0; }
    .chat-unread-badge { background: var(--chat-primary); color: #fff; font-size: .68rem; min-width: 18px; height: 18px; border-radius: 9px; display: inline-flex; align-items: center; justify-content: center; padding: 0 5px; }
    .chat-list-empty { text-align: center; color: #adb5bd; padding: 3rem 1rem; }
    .chat-list-empty i { font-size: 2.5rem; }

    .chat-window-pane { flex: 1; display: flex; flex-direction: column; min-width: 0; }
    .chat-window-empty { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #adb5bd; text-align: center; }
    .chat-window-empty i { font-size: 4rem; color: var(--chat-primary); opacity: .35; }
    .chat-window-active { flex: 1; display: flex; flex-direction: column; min-height: 0; }
    .chat-window-header { padding: .85rem 1.25rem; border-bottom: 1px solid #eee; }
    .chat-window-body { flex: 1; overflow-y: auto; padding: 1.25rem; background: #fafbfc; }
    .chat-window-footer { display: flex; align-items: center; gap: .5rem; padding: .75rem 1.25rem; border-top: 1px solid #eee; }
    .chat-window-footer input[type="text"] { flex: 1; border: 1px solid #e9ecef; border-radius: 20px; padding: .55rem 1rem; font-size: .9rem; background: #f8f9fa; }
    .chat-window-footer input[type="text"]:focus { outline: none; border-color: var(--chat-primary); }
    .chat-attach-btn, .chat-send-btn { border: none; background: var(--chat-primary-light); color: var(--chat-primary); width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0; }
    .chat-send-btn { background: var(--chat-primary); color: #fff; }
    .chat-attach-preview { display: flex; align-items: center; gap: .4rem; padding: 0 1.25rem .6rem; font-size: .8rem; color: #6c757d; }
    .chat-attach-preview button { border: none; background: none; color: #dc3545; }

    .chat-avatar { width: 44px; height: 44px; flex-shrink: 0; }
    .avatar-fallback { display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; background: var(--chat-primary); color: #fff; font-weight: 600; font-size: .85rem; }

    .chat-bubble-row { max-width: 65%; margin-bottom: 1rem; display: flex; flex-direction: column; }
    .chat-bubble-row.mine { margin-left: auto; align-items: flex-end; }
    .chat-bubble-row.theirs { margin-right: auto; align-items: flex-start; }
    .chat-sender-name { font-size: .72rem; color: #adb5bd; margin-bottom: .15rem; }
    .chat-bubble { padding: .6rem .9rem; border-radius: 14px; font-size: .88rem; word-break: break-word; }
    .chat-bubble-row.mine .chat-bubble { background: var(--chat-primary); color: #fff; border-bottom-right-radius: 4px; }
    .chat-bubble-row.theirs .chat-bubble { background: #fff; border: 1px solid #eee; border-bottom-left-radius: 4px; }
    .chat-bubble-time { font-size: .68rem; color: #adb5bd; margin-top: .25rem; }
    .chat-attachment-img { max-width: 220px; border-radius: 10px; margin-top: .3rem; display: block; }
    .chat-attachment-video { max-width: 260px; border-radius: 10px; margin-top: .3rem; display: block; }
    .chat-attachment-audio { margin-top: .3rem; width: 230px; height: 40px; display: block; }
    .chat-attachment-file { display: inline-flex; align-items: center; gap: .3rem; }

    .chat-mic-btn { border: none; background: var(--chat-primary-light); color: var(--chat-primary); width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0; }
    .chat-recording-bar { align-items: center; gap: .75rem; padding: .75rem 1.25rem; border-top: 1px solid #eee; }
    .chat-recording-cancel { border: none; background: #fdecea; color: #dc3545; width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0; }
    .chat-recording-indicator { flex: 1; display: flex; align-items: center; gap: .5rem; color: #dc3545; font-weight: 600; font-size: .9rem; }
    .chat-recording-hint { color: #adb5bd; font-weight: 400; font-size: .78rem; }
    .chat-recording-dot { width: 10px; height: 10px; border-radius: 50%; background: #dc3545; animation: chatPulse 1s infinite; }
    @keyframes chatPulse { 0%, 100% { opacity: 1; } 50% { opacity: .3; } }
    .chat-recording-send { border: none; background: var(--chat-primary); color: #fff; width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0; }

    .user-search-results { max-height: 320px; overflow-y: auto; }
    .user-result-row { display: flex; align-items: center; padding: .5rem .25rem; cursor: pointer; border-bottom: 1px solid #f5f5f5; }
    .user-result-row:hover { background: #f8f9fa; }

    .chat-mobile-back { display: none; border: none; background: transparent; color: var(--chat-primary); font-size: 1.3rem; padding: 0 .5rem 0 0; cursor: pointer; flex-shrink: 0; }
    .chat-header-info { cursor: pointer; border-radius: 8px; padding: .25rem .4rem; margin: -.25rem -.4rem; transition: background .15s; }
    .chat-header-info:hover { background: #f8f9fa; }

    .chat-profile-avatar { width: 96px; height: 96px; }
    .chat-profile-avatar .avatar-fallback, .chat-profile-avatar img { width: 96px; height: 96px; font-size: 2rem; }
    .chat-profile-details .chat-profile-row { display: flex; gap: .75rem; padding: .6rem 0; border-bottom: 1px solid #f5f5f5; }
    .chat-profile-details .chat-profile-row i { color: var(--chat-primary); font-size: 1.1rem; margin-top: .1rem; }
    .chat-profile-details .chat-profile-row .label { font-size: .72rem; color: #adb5bd; text-transform: uppercase; letter-spacing: .03em; }
    .chat-profile-details .chat-profile-row .value { font-size: .9rem; }
    .chat-profile-members .user-result-row { cursor: default; }

    @media (max-width: 767px) {
        .chat-app { height: calc(100vh - 130px); min-height: 480px; border-radius: 0; }
        .chat-list-pane { width: 100%; border-right: none; }
        .chat-window-pane { display: none; width: 100%; }
        .chat-mobile-back { display: inline-flex; align-items: center; }

        /* Added to .chat-app-inner by JS once a conversation is opened,
           so the list slides out of the way and the chat takes the full screen —
           removed again when the back button is tapped. */
        .chat-app-inner.mobile-chat-open .chat-list-pane { display: none; }
        .chat-app-inner.mobile-chat-open .chat-window-pane { display: flex; }

        .chat-bubble-row { max-width: 82%; }
        .modal-dialog { margin: .75rem; }
    }
</style>

<div class="card chat-app">
    <div class="chat-app-inner">

        {{-- ============== LEFT: CONVERSATION LIST ============== --}}
        <div class="chat-list-pane">
            <div class="chat-list-header">
                <h5 class="mb-0">Chat</h5>
                @can_permission('chat.create')
                <button type="button" class="btn-new-chat" data-bs-toggle="modal" data-bs-target="#newChatModal" title="New chat">
                    <i class="bx bx-edit-alt"></i>
                </button>
                @endcan_permission
            </div>

            <div class="chat-list-tabs">
                <button type="button" class="chat-tab active" data-type="">All</button>
                <button type="button" class="chat-tab" data-type="direct">Message</button>
                <button type="button" class="chat-tab" data-type="group">Group</button>
            </div>

            <div class="chat-list-search">
                <i class="bx bx-search"></i>
                <input type="text" id="chatListFilter" placeholder="Search conversations...">
            </div>

            <div class="chat-list-scroll" id="conversationList">
                <div class="chat-list-empty" id="conversationListEmpty">
                    <i class="bx bx-message-dots"></i>
                    <p>No conversations yet</p>
                    @can_permission('chat.create')
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#newChatModal">Start a chat</a>
                    @endcan_permission
                </div>
            </div>
        </div>

        {{-- ============== RIGHT: CHAT WINDOW ============== --}}
        <div class="chat-window-pane">
            <div id="chatWindowEmpty" class="chat-window-empty">
                <i class="bx bx-conversation"></i>
                <h5>No Conversation</h5>
                <p>You haven't selected a chat yet. Pick one from the list, or start a new one.</p>
            </div>

            <div id="chatWindowActive" class="chat-window-active d-none">
                <div class="chat-window-header">
                    <div class="d-flex align-items-center">
                        <button type="button" class="chat-mobile-back" id="chatMobileBack" title="Back to chats">
                            <i class="bx bx-arrow-back"></i>
                        </button>
                        <div class="chat-header-info d-flex align-items-center" id="chatHeaderInfo" role="button" title="View info">
                            <div class="chat-avatar" id="chatHeaderAvatar"></div>
                            <div class="ms-2">
                                <div class="fw-semibold" id="chatHeaderName">&nbsp;</div>
                                <small class="text-muted" id="chatHeaderSubtitle">&nbsp;</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="chat-window-body" id="chatMessages"></div>

                <form id="chatSendForm" class="chat-window-footer">
                    @csrf
                    <label class="chat-attach-btn" title="Attach a file">
                        <i class="bx bx-paperclip"></i>
                        <input type="file" name="attachment" id="chatAttachmentInput" hidden>
                    </label>
                    <input type="text" id="chatBodyInput" placeholder="Type your message" autocomplete="off">
                    <button type="button" class="chat-mic-btn" id="chatMicBtn" title="Record a voice note">
                        <i class="bx bx-microphone"></i>
                    </button>
                    <button type="submit" class="chat-send-btn"><i class="bx bx-send"></i></button>
                </form>
                <div class="chat-attach-preview d-none" id="chatAttachPreview">
                    <i class="bx bx-file"></i> <span></span>
                    <button type="button" id="chatAttachRemove"><i class="bx bx-x"></i></button>
                </div>
                <div class="chat-recording-bar d-none" id="chatRecordingBar">
                    <button type="button" class="chat-recording-cancel" id="chatRecordingCancel" title="Cancel">
                        <i class="bx bx-trash"></i>
                    </button>
                    <div class="chat-recording-indicator">
                        <span class="chat-recording-dot"></span>
                        <span id="chatRecordingTimer">0:00</span>
                        <span class="chat-recording-hint">&nbsp;&nbsp;&larr; Slide to cancel</span>
                    </div>
                    <button type="button" class="chat-recording-send" id="chatRecordingSend" title="Send voice note">
                        <i class="bx bx-send"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============== NEW CHAT MODAL ============== --}}
@can_permission('chat.create')
<div class="modal fade" id="newChatModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Chat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills mb-3" id="newChatModeTabs">
                    <li class="nav-item flex-fill text-center">
                        <button type="button" class="nav-link active w-100" data-mode="direct">Direct Message</button>
                    </li>
                    <li class="nav-item flex-fill text-center">
                        <button type="button" class="nav-link w-100" data-mode="group">Group Chat</button>
                    </li>
                </ul>

                <div id="groupNameWrap" class="mb-3 d-none">
                    <input type="text" id="groupNameInput" class="form-control" placeholder="Group name">
                </div>

                <div class="chat-list-search mb-2">
                    <i class="bx bx-search"></i>
                    <input type="text" id="userSearchInput" placeholder="Search staff by name or username...">
                </div>

                <div id="userSearchResults" class="user-search-results"></div>
            </div>
            <div class="modal-footer" id="groupCreateFooter" style="display:none;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="createGroupBtn">Create Group</button>
            </div>
        </div>
    </div>
</div>
@endcan_permission

{{-- ============== CONTACT / GROUP INFO MODAL (opens on tapping the chat header) ============== --}}
<div class="modal fade" id="profileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center" id="profileModalBody">
                <div class="chat-profile-avatar mx-auto" id="profileAvatar"></div>
                <h5 class="mt-3 mb-0" id="profileName">&nbsp;</h5>
                <p class="text-muted mb-3" id="profileSubtitle">&nbsp;</p>
                <div class="chat-profile-details text-start" id="profileDetails"></div>
                <div class="chat-profile-members text-start d-none" id="profileMembers">
                    <h6 class="text-muted mb-2 mt-2">Members</h6>
                    <div id="profileMembersList"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
(function () {
    const routes = {
        conversations: "{{ route('chat.conversations') }}",
        userSearch: "{{ route('chat.users.search') }}",
        startDirect: "{{ route('chat.start.direct') }}",
        createGroup: "{{ route('chat.create.group') }}",
        messagesBase: "{{ url('chat') }}", // /{id}/messages, /{id}/poll, /{id}/messages (POST)
    };
    const csrf = document.querySelector('#chatSendForm input[name="_token"]')?.value
        || document.querySelector('meta[name="csrf-token"]')?.content;
    const currentUserId = {{ optional(\App\Services\AccessControl::user())->id ?? 'null' }};

    let currentConversationId = null;
    let renderedMessageIds = new Set();
    let currentTab = '';
    let pollTimer = null;
    let lastMessageTs = null;
    let selectedGroupUsers = {};
    let newChatMode = 'direct';

    const el = (id) => document.getElementById(id);

    function initials(name) {
        return (name || '?').split(' ').filter(Boolean).slice(0, 2).map(w => w[0].toUpperCase()).join('');
    }

    function avatarHtml(name, avatarUrl, size) {
        size = size || 44;
        if (avatarUrl) {
            return `<img src="${avatarUrl}" style="width:${size}px;height:${size}px;border-radius:50%;object-fit:cover;">`;
        }
        return `<span class="avatar-fallback" style="width:${size}px;height:${size}px;">${initials(name)}</span>`;
    }

    function loadConversations() {
        fetch(routes.conversations + (currentTab ? ('?type=' + currentTab) : ''))
            .then(r => r.json())
            .then(d => {
                if (!d.status) return;
                renderConversationList(d.conversations);
            });
    }

    function renderConversationList(list) {
        const wrap = el('conversationList');
        const emptyState = `
            <div class="chat-list-empty">
                <i class="bx bx-message-dots"></i>
                <p>No conversations yet</p>
            </div>`;

        if (!list.length) {
            wrap.innerHTML = emptyState;
            return;
        }

        wrap.innerHTML = list.map(c => `
            <div class="chat-list-item ${c.id == currentConversationId ? 'active' : ''}" data-id="${c.id}" data-name="${(c.name || '').toLowerCase()}">
                <div class="chat-avatar">${avatarHtml(c.name, c.avatar)}</div>
                <div class="chat-list-item-body">
                    <div class="d-flex justify-content-between">
                        <span class="fw-semibold text-truncate">${c.name}</span>
                        <small class="text-muted flex-shrink-0 ms-1">${c.last_message_at || ''}</small>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted text-truncate">${c.last_message}</small>
                        ${c.unread > 0 ? `<span class="chat-unread-badge">${c.unread}</span>` : ''}
                    </div>
                </div>
            </div>
        `).join('');

        wrap.querySelectorAll('.chat-list-item').forEach(item => {
            item.addEventListener('click', () => openConversation(item.dataset.id));
        });
    }

    function openConversation(id) {
        currentConversationId = id;
        lastMessageTs = null;
        renderedMessageIds = new Set();
        clearInterval(pollTimer);

        el('chatWindowEmpty').classList.add('d-none');
        el('chatWindowActive').classList.remove('d-none');
        el('chatMessages').innerHTML = '';
        document.querySelector('.chat-app-inner')?.classList.add('mobile-chat-open');

        fetch(`${routes.messagesBase}/${id}/messages`)
            .then(r => r.json())
            .then(d => {
                if (!d.status) return;
                el('chatHeaderAvatar').innerHTML = avatarHtml(d.header.name, d.header.avatar);
                el('chatHeaderName').textContent = d.header.name;
                el('chatHeaderSubtitle').textContent = d.header.subtitle || '';

                d.messages.forEach(appendMessage);
                scrollToBottom();
                if (d.messages.length) {
                    lastMessageTs = d.messages[d.messages.length - 1].created_ts;
                }
                loadConversations(); // refresh unread badges / ordering

                pollTimer = setInterval(() => pollMessages(id), 4000);
            });
    }

    function pollMessages(id) {
        const url = `${routes.messagesBase}/${id}/poll` + (lastMessageTs ? `?since=${lastMessageTs}` : '');
        fetch(url).then(r => r.json()).then(d => {
            if (!d.status || !d.messages.length) return;
            d.messages.forEach(appendMessage);
            lastMessageTs = d.messages[d.messages.length - 1].created_ts;
            scrollToBottom();
            loadConversations();
        });
    }

    function appendMessage(m) {
        // A message can arrive twice — once from the immediate send response,
        // once from the next poll tick that fired before "since" was updated.
        // Skip anything we've already rendered instead of trying to time the
        // race perfectly.
        if (renderedMessageIds.has(m.id)) return;
        renderedMessageIds.add(m.id);

        const mine = m.sender_id == currentUserId;
        const wrap = el('chatMessages');
        const bubble = document.createElement('div');
        bubble.className = 'chat-bubble-row ' + (mine ? 'mine' : 'theirs');

        let attachmentHtml = '';
        if (m.attachment) {
            if (m.attachment_type === 'image') {
                attachmentHtml = `<a href="${m.attachment}" target="_blank"><img src="${m.attachment}" class="chat-attachment-img"></a>`;
            } else if (m.attachment_type === 'video') {
                attachmentHtml = `<video src="${m.attachment}" controls class="chat-attachment-video"></video>`;
            } else if (m.attachment_type === 'audio') {
                attachmentHtml = `<audio src="${m.attachment}" controls class="chat-attachment-audio"></audio>`;
            } else {
                attachmentHtml = `<a href="${m.attachment}" target="_blank" class="chat-attachment-file"><i class="bx bx-file"></i> Download attachment</a>`;
            }
        }

        bubble.innerHTML = `
            ${!mine ? `<div class="chat-sender-name">${m.sender_name}</div>` : ''}
            <div class="chat-bubble">
                ${m.body ? `<div>${escapeHtml(m.body)}</div>` : ''}
                ${attachmentHtml}
            </div>
            <div class="chat-bubble-time">${m.created_at}</div>
        `;
        wrap.appendChild(bubble);
    }

    function escapeHtml(str) {
        const d = document.createElement('div');
        d.innerText = str;
        return d.innerHTML;
    }

    function scrollToBottom() {
        const wrap = el('chatMessages');
        wrap.scrollTop = wrap.scrollHeight;
    }

    // --- Sending messages ---
    el('chatSendForm').addEventListener('submit', function (e) {
        e.preventDefault();
        if (!currentConversationId) return;

        const body = el('chatBodyInput').value.trim();
        const file = el('chatAttachmentInput').files[0];
        if (!body && !file) return;

        const fd = new FormData();
        if (body) fd.append('body', body);
        if (file) fd.append('attachment', file);

        fetch(`${routes.messagesBase}/${currentConversationId}/messages`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            body: fd,
        })
            .then(r => r.json())
            .then(d => {
                if (!d.status) { alert(d.message || 'Could not send message.'); return; }
                appendMessage(d.message);
                lastMessageTs = d.message.created_ts;
                scrollToBottom();
                el('chatBodyInput').value = '';
                el('chatAttachmentInput').value = '';
                el('chatAttachPreview').classList.add('d-none');
                loadConversations();
            });
    });

    el('chatAttachmentInput')?.addEventListener('change', function () {
        const file = this.files[0];
        const preview = el('chatAttachPreview');
        if (!file) { preview.classList.add('d-none'); return; }
        preview.querySelector('span').textContent = file.name;
        preview.classList.remove('d-none');
    });

    el('chatAttachRemove')?.addEventListener('click', function () {
        el('chatAttachmentInput').value = '';
        el('chatAttachPreview').classList.add('d-none');
    });

    // --- Voice notes (WhatsApp-style mic recording) ---
    let mediaRecorder = null;
    let recordedChunks = [];
    let recordingStartedAt = null;
    let recordingTimerInterval = null;
    let awaitingStream = false;      // true while getUserMedia() hasn't resolved yet
    let pendingStopAction = null;    // 'send' | 'cancel' — set if released before the mic was ready
    let recordingCancelled = false;
    let pointerStartX = 0;

    function startRecording() {
        if (!currentConversationId || awaitingStream || (mediaRecorder && mediaRecorder.state === 'recording')) return;

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            alert('Voice recording is not supported in this browser.');
            return;
        }

        awaitingStream = true;
        pendingStopAction = null;
        recordingCancelled = false;

        navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
            awaitingStream = false;
            recordedChunks = [];
            mediaRecorder = new MediaRecorder(stream);

            mediaRecorder.ondataavailable = (e) => {
                if (e.data && e.data.size > 0) recordedChunks.push(e.data);
            };

            mediaRecorder.start();
            recordingStartedAt = Date.now();

            el('chatSendForm').classList.add('d-none');
            el('chatRecordingBar').classList.remove('d-none');
            el('chatRecordingBar').classList.add('d-flex');

            updateRecordingTimer();
            recordingTimerInterval = setInterval(updateRecordingTimer, 250);

            // The user may have already released the mic button while we
            // were still waiting on the permission prompt / stream setup —
            // honour whatever they asked for the moment we're ready.
            if (pendingStopAction === 'send') {
                sendRecording();
            } else if (pendingStopAction === 'cancel') {
                cancelRecording();
            }
            pendingStopAction = null;
        }).catch(() => {
            awaitingStream = false;
            alert('Microphone access was denied or is unavailable.');
        });
    }

    function updateRecordingTimer() {
        const totalSeconds = Math.floor((Date.now() - recordingStartedAt) / 1000);
        const mins = Math.floor(totalSeconds / 60);
        const secs = totalSeconds % 60;
        const label = el('chatRecordingTimer');
        if (label) label.textContent = `${mins}:${secs.toString().padStart(2, '0')}`;
    }

    function stopRecordingUi() {
        clearInterval(recordingTimerInterval);
        if (mediaRecorder && mediaRecorder.stream) {
            mediaRecorder.stream.getTracks().forEach(track => track.stop());
        }
        el('chatRecordingBar').classList.add('d-none');
        el('chatRecordingBar').classList.remove('d-flex');
        el('chatSendForm').classList.remove('d-none');
    }

    function cancelRecording() {
        if (mediaRecorder && mediaRecorder.state !== 'inactive') {
            mediaRecorder.onstop = () => { recordedChunks = []; };
            mediaRecorder.stop();
        }
        stopRecordingUi();
    }

    function sendRecording() {
        if (!mediaRecorder || mediaRecorder.state === 'inactive') return;

        mediaRecorder.onstop = () => {
            const blob = new Blob(recordedChunks, { type: 'audio/webm' });
            uploadVoiceNote(blob);
        };
        mediaRecorder.stop();
        stopRecordingUi();
    }

    function uploadVoiceNote(blob) {
        if (!currentConversationId) return;

        const fd = new FormData();
        fd.append('attachment', blob, 'voice-note.webm');

        fetch(`${routes.messagesBase}/${currentConversationId}/messages`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            body: fd,
        })
            .then(r => r.json())
            .then(d => {
                if (!d.status) { alert(d.message || 'Could not send voice note.'); return; }
                appendMessage(d.message);
                lastMessageTs = d.message.created_ts;
                scrollToBottom();
                loadConversations();
            });
    }

    function handleMicDown(e) {
        e.preventDefault();
        if (!currentConversationId) return;
        pointerStartX = (e.touches ? e.touches[0].clientX : e.clientX);
        if (mediaRecorder && mediaRecorder.state === 'recording') return;
        startRecording();
    }

    function handleMicMove(e) {
        const isActive = awaitingStream || (mediaRecorder && mediaRecorder.state === 'recording');
        if (!isActive || recordingCancelled) return;

        const x = (e.touches ? e.touches[0].clientX : e.clientX);
        if (pointerStartX - x > 80) { // dragged left far enough — WhatsApp's "slide to cancel"
            recordingCancelled = true;
            if (mediaRecorder && mediaRecorder.state === 'recording') {
                cancelRecording();
            } else {
                pendingStopAction = 'cancel';
            }
        }
    }

    function handleMicUp() {
        const isActive = awaitingStream || (mediaRecorder && mediaRecorder.state === 'recording');
        if (!isActive) return;

        if (mediaRecorder && mediaRecorder.state === 'recording') {
            if (!recordingCancelled) sendRecording();
        } else if (awaitingStream) {
            // Still waiting on the permission prompt / getUserMedia() — the
            // start handler above will act on this the instant it's ready.
            pendingStopAction = recordingCancelled ? 'cancel' : 'send';
        }
    }

    el('chatMicBtn')?.addEventListener('mousedown', handleMicDown);
    el('chatMicBtn')?.addEventListener('touchstart', handleMicDown, { passive: false });
    document.addEventListener('mousemove', handleMicMove);
    document.addEventListener('touchmove', handleMicMove, { passive: true });
    document.addEventListener('mouseup', handleMicUp);
    document.addEventListener('touchend', handleMicUp);

    // Tap fallbacks on the bar itself (useful if a hold gesture is awkward,
    // e.g. trackpad users) — both just call the same functions directly.
    el('chatRecordingCancel')?.addEventListener('click', cancelRecording);
    el('chatRecordingSend')?.addEventListener('click', sendRecording);

    // --- Mobile: back button returns from the open chat to the list ---
    function closeMobileChat() {
        document.querySelector('.chat-app-inner')?.classList.remove('mobile-chat-open');
        clearInterval(pollTimer);
        currentConversationId = null;
    }

    // Bound on the capture phase and with stopPropagation so nothing in the
    // surrounding admin template (which may have its own delegated click
    // handlers listening for icon classes like "bx-arrow-back") can swallow
    // this before it reaches us.
    el('chatMobileBack')?.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        closeMobileChat();
    }, true);

    // --- Contact / group info (tapping the avatar+name in the chat header) ---
    el('chatHeaderInfo')?.addEventListener('click', function () {
        if (!currentConversationId) return;

        fetch(`${routes.messagesBase}/${currentConversationId}/profile`)
            .then(r => r.json())
            .then(d => {
                if (!d.status) return;
                renderProfileModal(d);
                new bootstrap.Modal(el('profileModal')).show();
            });
    });

    function renderProfileModal(d) {
        el('profileMembers').classList.add('d-none');
        el('profileDetails').innerHTML = '';

        if (d.type === 'direct') {
            const u = d.user;
            el('profileAvatar').innerHTML = avatarHtml(u.name, u.avatar, 96);
            el('profileName').textContent = u.name;
            el('profileSubtitle').textContent = u.role || '';

            const rows = [
                ['bx-envelope', 'Email', u.email],
                ['bx-phone', 'Phone', u.phone],
                ['bx-map', 'District', u.district],
                ['bx-building', 'Mosque', u.mosque],
            ].filter(([, , value]) => value);

            el('profileDetails').innerHTML = rows.map(([icon, label, value]) => `
                <div class="chat-profile-row">
                    <i class="bx ${icon}"></i>
                    <div>
                        <div class="label">${label}</div>
                        <div class="value">${escapeHtml(value)}</div>
                    </div>
                </div>
            `).join('') || '<p class="text-muted text-center">No further details on file.</p>';
        } else {
            const g = d.group;
            el('profileAvatar').innerHTML = avatarHtml(g.name, g.avatar, 96);
            el('profileName').textContent = g.name;
            el('profileSubtitle').textContent = `${g.members_count} members`;

            el('profileMembers').classList.remove('d-none');
            el('profileMembersList').innerHTML = d.members.map(m => `
                <div class="user-result-row">
                    <div class="chat-avatar">${avatarHtml(m.name, m.avatar, 36)}</div>
                    <div class="flex-grow-1 ms-2">
                        <div class="fw-semibold">${escapeHtml(m.name)}${m.is_admin ? ' <span class="badge bg-light text-dark">Admin</span>' : ''}</div>
                        <small class="text-muted">${m.role || ''}</small>
                    </div>
                </div>
            `).join('');
        }
    }

    // --- Tabs ---
    document.querySelectorAll('.chat-tab').forEach(tab => {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.chat-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            currentTab = this.dataset.type;
            loadConversations();
        });
    });

    // --- Client-side name filter ---
    el('chatListFilter')?.addEventListener('input', function () {
        const term = this.value.toLowerCase();
        document.querySelectorAll('.chat-list-item').forEach(item => {
            item.style.display = item.dataset.name.includes(term) ? '' : 'none';
        });
    });

    // --- New chat modal ---
    document.querySelectorAll('#newChatModeTabs .nav-link').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('#newChatModeTabs .nav-link').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            newChatMode = this.dataset.mode;
            selectedGroupUsers = {};
            el('groupNameWrap').classList.toggle('d-none', newChatMode !== 'group');
            el('groupCreateFooter').style.display = newChatMode === 'group' ? '' : 'none';
            searchUsers('');
        });
    });

    let searchDebounce;
    el('userSearchInput')?.addEventListener('input', function () {
        clearTimeout(searchDebounce);
        const term = this.value;
        searchDebounce = setTimeout(() => searchUsers(term), 250);
    });

    function searchUsers(term) {
        fetch(routes.userSearch + '?q=' + encodeURIComponent(term))
            .then(r => r.json())
            .then(d => {
                if (!d.status) return;
                renderUserResults(d.users);
            });
    }

    function renderUserResults(users) {
        const wrap = el('userSearchResults');
        if (!users.length) {
            wrap.innerHTML = '<p class="text-muted text-center py-3">No staff found.</p>';
            return;
        }

        wrap.innerHTML = users.map(u => `
            <div class="user-result-row" data-id="${u.id}">
                <div class="chat-avatar">${avatarHtml(u.name, u.avatar, 36)}</div>
                <div class="flex-grow-1 ms-2">
                    <div class="fw-semibold">${u.name}</div>
                    <small class="text-muted">${u.role || ''}</small>
                </div>
                ${newChatMode === 'group' ? `<input type="checkbox" class="form-check-input group-user-check" ${selectedGroupUsers[u.id] ? 'checked' : ''}>` : ''}
            </div>
        `).join('');

        wrap.querySelectorAll('.user-result-row').forEach(row => {
            row.addEventListener('click', function (e) {
                const id = this.dataset.id;
                if (newChatMode === 'direct') {
                    startDirectChat(id);
                } else {
                    const checkbox = this.querySelector('.group-user-check');
                    if (e.target !== checkbox) checkbox.checked = !checkbox.checked;
                    selectedGroupUsers[id] = checkbox.checked ? true : undefined;
                    if (!checkbox.checked) delete selectedGroupUsers[id];
                }
            });
        });
    }

    function startDirectChat(userId) {
        fetch(routes.startDirect, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            body: JSON.stringify({ user_id: userId }),
        })
            .then(r => r.json())
            .then(d => {
                if (!d.status) { alert(d.message || 'Could not start chat.'); return; }
                bootstrap.Modal.getInstance(el('newChatModal'))?.hide();
                loadConversations();
                openConversation(d.conversation_id);
            });
    }

    el('createGroupBtn')?.addEventListener('click', function () {
        const name = el('groupNameInput').value.trim();
        const userIds = Object.keys(selectedGroupUsers);
        if (!name) { alert('Please name the group.'); return; }
        if (!userIds.length) { alert('Select at least one member.'); return; }

        fetch(routes.createGroup, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            body: JSON.stringify({ name: name, user_ids: userIds }),
        })
            .then(r => r.json())
            .then(d => {
                if (!d.status) { alert(d.message || 'Could not create group.'); return; }
                bootstrap.Modal.getInstance(el('newChatModal'))?.hide();
                el('groupNameInput').value = '';
                selectedGroupUsers = {};
                loadConversations();
                openConversation(d.conversation_id);
            });
    });

    document.getElementById('newChatModal')?.addEventListener('show.bs.modal', function () {
        searchUsers('');
    });

    // Kick things off
    loadConversations();
    setInterval(loadConversations, 10000); // keep the list itself fresh too
})();
</script>
@endsection