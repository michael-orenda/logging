<?php

namespace MichaelOrenda\Logging\Services;

use MichaelOrenda\Logging\Events\LogCreated;
use MichaelOrenda\Logging\Models\SecurityLog;

class SecurityChannel
{
    public function write(string $event, array $context = [], ?string $severity = null)
    {
        $severity = $severity ?? config("logging.events.$event.severity")
                    ?? config('logging.default_severity.security');

        return SecurityLog::create([
            'event' => $event,
            'severity' => $severity,
            'message' => $context['message'] ?? null,
            'context' => $context,
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'source' => $context['source'] ?? 'app'
        ]);
        event(new LogCreated($log, $context));

        return $log;
    }
}
