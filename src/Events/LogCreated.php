<?php

namespace MichaelOrenda\Logging\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LogCreated
{
    use Dispatchable, SerializesModels;

    public string $category;
    /** @var object|array|null */
    public $log;
    public array $context;

    /**
     * @param string $category  'activity' | 'security' | 'error'
     * @param object|array|null $log  the created log model instance or an array payload
     * @param array $context   optional context
     */
    public function __construct(string $category, $log = null, array $context = [])
    {
        $this->category = $category;
        $this->log = $log;
        $this->context = $context;
    }
}
