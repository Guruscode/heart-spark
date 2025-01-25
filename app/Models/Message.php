<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;


    public function messages()
    {
        return $this->hasMany(Message::class, 'recipient_id'); // Assuming recipient_id is the foreign key in the messages table
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id'); // Assuming sender_id is the foreign key
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id'); // Assuming recipient_id is the foreign key
    }
}
