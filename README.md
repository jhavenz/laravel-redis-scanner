# Laravel Redis Scanner

Anyone else notice how annoying it is to do simple loops over Redis data?

I didn't see any packages out there that made this easy, so I'll be making one.
I don't intend to put many bells and whistles on this, I'd just like to be able to
iterator over Redis data without having to write out the manual looping logic every time.

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

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jonathan Havens](https://github.com/jhavenz)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
