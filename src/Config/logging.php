<?php

return [

    // Default severity per event type (can be overridden at runtime)
    'default_severity' => [
        'activity' => 'info',
        'security' => 'warning',
        'error'    => 'error',
    ],

    // Map of standardized events
    'events' => [
        'login_failed' => ['type' => 'security', 'severity' => 'warning'],
        'unauthorized_access_attempt' => ['type' => 'security', 'severity' => 'critical'],

        'record_created' => ['type' => 'activity', 'severity' => 'info'],
        'record_updated' => ['type' => 'activity', 'severity' => 'notice'],

        'exception_thrown' => ['type' => 'error', 'severity' => 'error'],
    ],

    // Retention per table
    'retention_days' => [
        'activity' => 365,
        'security' => 1095,
        'error'    => 90,
    ],

    // Should critical logs trigger notifications?
    'notify_on_critical' => true,
];
