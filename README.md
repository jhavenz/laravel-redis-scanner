# Laravel Redis Scanner

A simple package to iterate over Redis data without having to write out the manual looping logic every time.

> Note: So far, this is just an idea for a package I've put together. It's not production ready

## Installation

You can install the package via composer:

```bash
composer require jhavenz/laravel-redis-scanner
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-redis-scanner-config"
```

This is the contents of the published config file:

```php
return [
    'connection' => env('REDIS_SCANNER_CONNECTION', 'default'),
];
```

## Usage

```php
use Jhavenz\LaravelRedisScanner\Facades\RedisScanner;
use Jhavenz\LaravelRedisScanner\ScannedValue;

// Scan a redis pattern and match the results 
$users = collect(RedisScanner::scan(pattern: 'users:*', count: 100))
    ->map(fn(ScannedValue $s) => $s->redisValue());

```

## Testing

```bash
composer test
```

## Credits

- [Jonathan Havens](https://github.com/jhavenz)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
