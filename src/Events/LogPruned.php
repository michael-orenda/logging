<?php

namespace MichaelOrenda\Logging\Events;

class LogPruned
{
    public function __construct(
        public string $category,
        public int $count
    ) {}
}
