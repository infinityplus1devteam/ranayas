<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MailLog extends Model
{
    protected $table = 'mail_logs';

    protected $fillable = [
        'from_name',
        'from_email',
        'phone',
        'subject',
        'message',
        'form_source',
        'status',
        'error_message',
        'error_code',
        'ip_address',
        'user_agent',
    ];
}
