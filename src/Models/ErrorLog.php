<?php

namespace MichaelOrenda\Logging\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    protected $fillable = [
        'event', 'severity', 'message', 'context',
        'stack_trace', 'source'
    ];

    protected $casts = [
        'context' => 'array'
    ];
}
