<?php

use MichaelOrenda\Logging\Facades\Logger;

if (! function_exists('log_activity')) {
    function log_activity(string $event, array $context = [], ?string $severity = null) {
        return Logger::activity($event, $context, $severity);
    }
}

if (! function_exists('log_security')) {
    function log_security(string $event, array $context = [], ?string $severity = null) {
        return Logger::security($event, $context, $severity);
    }
}

if (! function_exists('log_error')) {
    function log_error(string $event, array $context = [], ?string $severity = null) {
        return Logger::error($event, $context, $severity);
    }
}
