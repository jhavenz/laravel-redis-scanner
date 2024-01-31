<?php

namespace Jhavenz\LaravelRedisScanner\Commands;

use Illuminate\Console\Command;

class LaravelRedisScannerCommand extends Command
{
    public $signature = 'laravel-redis-scanner';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
