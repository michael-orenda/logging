<?php

namespace MichaelOrenda\Logging\Providers;

use Illuminate\Support\ServiceProvider;
use MichaelOrenda\Logging\Services\LoggerManager;
use MichaelOrenda\Logging\Facades\Logger;
use Illuminate\Support\Facades\Route;

class LoggingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/logging.php', 'logging');

        $this->app->singleton('logger.manager', function () {
            return new LoggerManager();
        });

        $this->registerHelpers();

    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../Config/logging.php' => config_path('logging.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');


        if ($this->app->runningInConsole()) {
            $this->commands([
                \MichaelOrenda\Logging\Console\Commands\PruneLogsCommand::class,
            ]);
        }
    }

    protected function registerHelpers()
    {
        $helpers = __DIR__ . '/../Support/helpers.php';

        if (file_exists($helpers)) {
            require_once $helpers;
        }
    }
}
