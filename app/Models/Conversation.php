<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['type', 'name', 'avatar', 'created_by'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'conversation_participants')
            ->withPivot(['is_admin', 'last_read_at', 'joined_at', 'left_at'])
            ->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at');
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * For a direct (1-on-1) conversation, the participant who isn't $userId.
     */
    public function otherParticipant(int $userId): ?User
    {
        if ($this->type !== 'direct') {
            return null;
        }

        return $this->users->firstWhere('id', '!=', $userId);
    }
}
