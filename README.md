# Michael Orenda — Logging Package  
### Unified Activity, Security & Error Logging for Laravel (Hybrid Architecture)

This package provides a clean, modular logging system for Laravel applications, featuring:

- **Activity logs** (CRUD actions, workflow events, system events)  
- **Security logs** (authentication, authorization, threat detection)  
- **Error logs** (exceptions, failures, runtime errors)  
- **Unified logging facade**: `Logger::activity()`, `Logger::security()`, `Logger::error()`  
- **Global helper functions**: `log_activity()`, `log_security()`, `log_error()`  
- **Configurable log retention**  
- **Pruning command** (`logging:prune`)  
- Designed for integration with Notification + Error Manager packages

## 🚀 Installation

```bash
composer require michael-orenda/logging
```

If using a local path repository during development:

```json
"repositories": [
    {
        "type": "path",
        "url": "../logging"
    }
]
```

Then:

```bash
composer require michael-orenda/logging:@dev
```

Laravel will auto-discover the service provider.

## 📦 Publish Config (optional)

```bash
php artisan vendor:publish --tag=config
```

## 🛢 Run Migrations

```bash
php artisan migrate
```

## 🔥 Usage

### Activity Logging

```php
Logger::activity('record_created', ['id' => 10]);
```

Or helper:

```php
log_activity('record_created', ['id' => 10]);
```

### Security Logging

```php
Logger::security('login_failed', ['ip' => request()->ip()]);
```

### Error Logging

```php
Logger::error('exception_thrown', ['message' => 'Something broke']);
```

# 🧹 Pruning Old Logs

```bash
php artisan logging:prune
```

### Override:

```bash
php artisan logging:prune --days=30
```

### Prune specific types:

```bash
php artisan logging:prune --activity
```

# ⏱ Schedule It

Add to `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('logging:prune')->daily();
}
```

# 📄 License

MIT
