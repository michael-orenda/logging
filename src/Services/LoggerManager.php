<?php

namespace MichaelOrenda\Logging\Services;

use MichaelOrenda\Logging\Services\ActivityChannel;
use MichaelOrenda\Logging\Services\SecurityChannel;
use MichaelOrenda\Logging\Services\ErrorChannel;

class LoggerManager
{
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
