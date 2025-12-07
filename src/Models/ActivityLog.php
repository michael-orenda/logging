<?php

namespace MichaelOrenda\Logging\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'event', 'severity', 'message', 'context',
        'user_id', 'ip', 'user_agent', 'source',
    ];

    protected $casts = [
        'context' => 'array'
    ];
}
