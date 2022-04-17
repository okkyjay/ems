<?php

namespace App\EMS\MessageConversation;


use Illuminate\Database\Eloquent\Model;

class MessageConversation extends Model
{

    public $table = 'message_conversations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'chat_employee_id',
        'message_id',
        'message',
        'is_read',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
