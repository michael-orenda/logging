# API Documentation

## Activity Log
The Activity Log captures user and system events.

### Create Activity Log Entry
```php
Logger::activity('user_logged_in', ['user_id' => $user->id]);
```

## Security Log
The Security Log captures security-related events such as failed login attempts.

### Create Security Log Entry
```php
Logger::security('unauthorized_access', ['ip' => $ip]);
```

## Error Log
The Error Log captures application errors, including exceptions.

### Create Error Log Entry
```php
Logger::error('payment_failed', ['order_id' => $orderId]);
```
