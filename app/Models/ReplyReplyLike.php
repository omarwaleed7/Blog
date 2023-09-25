<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyReplyLike extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'reply_reply_id'
    ];
}
