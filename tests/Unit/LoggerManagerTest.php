<?php

namespace MichaelOrenda\Logging\Tests\Unit;

use MichaelOrenda\Logging\Facades\Logger;
use MichaelOrenda\Logging\Models\ActivityLog;
use Orchestra\Testbench\TestCase;

class LoggerManagerTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [\MichaelOrenda\Logging\Providers\LoggingServiceProvider::class];
    }

    public function test_activity_log_is_written()
    {
        Logger::activity('record_created', ['foo' => 'bar']);

        $this->assertDatabaseHas('activity_logs', [
            'event' => 'record_created'
        ]);
    }
}
