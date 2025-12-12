<?php

namespace MichaelOrenda\Logging\Services;

use MichaelOrenda\Logging\Services\ActivityChannel;
use MichaelOrenda\Logging\Services\SecurityChannel;
use MichaelOrenda\Logging\Services\ErrorChannel;

class LoggerManager
{
    public function __call($method, $args)
    {
        $levels = [
            'debug'   => 'activity',
            'info'    => 'activity',
            'notice'  => 'activity',

            'warning' => 'security',
            'alert'   => 'security',

            'error'   => 'error',
            'critical'=> 'error',
            'emergency' => 'error',
        ];

        if (isset($levels[$method])) {
            $event   = $args[0] ?? 'event';
            $context = $args[1] ?? [];

            return $this->{$levels[$method]}($event, $context);
        }

        throw new \BadMethodCallException("Method [$method] does not exist.");
    }

    public function activity(string $event, array $context = [], ?string $severity = null)
    {
        return (new ActivityChannel())->write($event, $context, $severity);
    }

    public function security(string $event, array $context = [], ?string $severity = null)
    {
        return (new SecurityChannel())->write($event, $context, $severity);
    }

    public function error(string $event, array $context = [], ?string $severity = null)
    {
        return (new ErrorChannel())->write($event, $context, $severity);
    }
}
