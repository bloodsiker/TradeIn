<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    const TYPE_PRIVATE = 1;
    const TYPE_GROUP   = 2;

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function messages_user()
    {
        return $this->hasMany(ChatMessageUser::class);
    }

    public function getNewMessagesAttribute()
    {
        return $this->hasMany(ChatMessageUser::class)->whereUserId(\Auth::id())->count();

    }
}
