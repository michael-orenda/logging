<?php

namespace MichaelOrenda\Logging\Events;

use MichaelOrenda\Logging\Models\ActivityLog;
use MichaelOrenda\Logging\Models\SecurityLog;
use MichaelOrenda\Logging\Models\ErrorLog;

class LogCreated
{
    public function __construct(
        public string $category,
        public object $logEntry
    ) {}
}
