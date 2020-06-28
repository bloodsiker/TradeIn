<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessageUser extends Model
{
    protected $table = 'chat_message_user';

    public function chat()
    {
        return $this->hasOne(Chat::class, 'id', 'chat_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function message()
    {
        return $this->hasOne(ChatMessage::class, 'id', 'message_id');
    }
}
