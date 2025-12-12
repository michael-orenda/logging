# Michael Orenda Logging Package

## Overview
`michael-orenda/logging` is a robust logging package for Laravel applications. It supports:

- Activity Logs
- Security Logs
- Error Logs
- Facade API
- Helper functions
- Loggable Trait for automatic logging
- Pruning & archiving logs
- Event dispatching for log-related events

## Features

- Unified logging API for Activity, Security, and Error Logs.
- Automatic logging of model CRUD actions with `Loggable` trait.
- Prune old logs with the `logging:prune` command.
- Provides endpoints for admin access to logs.

## Installation

Install using Composer:

```bash
composer require michael-orenda/logging
```

Publish the configuration:

```bash
php artisan vendor:publish --tag=logging-config
```

Run migrations:

```bash
php artisan migrate
```

## Configuration

The configuration is located in `config/logging.php`. You can set log retention policies, default severities, and other parameters.

## Usage

You can log events using the facade:

```php
Logger::activity('user_logged_in', ['user_id' => $user->id]);
Logger::security('unauthorized_access', ['ip' => $ip]);
Logger::error('payment_failed', ['order_id' => $orderId]);
```

## API Endpoints

- `/orenda/logs/activity`
- `/orenda/logs/security`
- `/orenda/logs/error`

These endpoints return the logs in JSON format and support pagination.

## Loggable Trait

To log model CRUD events, add the `Loggable` trait:

```php
use Loggable;

class User extends Model
{
    use Loggable;
}
```

---

# License

MIT License
