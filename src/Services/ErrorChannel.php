<?php

namespace MichaelOrenda\Logging\Services;

use MichaelOrenda\Logging\Models\ErrorLog;

class ErrorChannel
{
    public function write(string $event, array $context = [], ?string $severity = null)
    {
        $severity = $severity ?? config("logging.events.$event.severity")
                    ?? config('logging.default_severity.error');

        return ErrorLog::create([
            'event' => $event,
            'severity' => $severity,
            'message' => $context['message'] ?? null,
            'context' => $context,
            'stack_trace' => $context['trace'] ?? null,
            'source' => $context['source'] ?? 'app',
        ]);
    }
}
