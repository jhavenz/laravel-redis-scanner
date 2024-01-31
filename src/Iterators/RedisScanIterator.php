<?php

declare(strict_types=1);

namespace Jhavenz\LaravelRedisScanner\Iterators;

use CallbackFilterIterator;
use Closure;
use IteratorAggregate;
use IteratorIterator;
use Jhavenz\LaravelRedisScanner\ScannedValue;
use Traversable;

/**
 * @implements IteratorAggregate<string, ScannedValue>
 */
class RedisScanIterator implements IteratorAggregate
{
    private array $cache = [];

    private bool $stop = false;

    private bool $bypass = false;

    private Closure $filterCallback;

    public function __construct(
        private ?string $pattern = null,
        private ?int $limit = 250,
        private ?string $type = null,
        private ?string $connectionName = null,
        private bool $withoutDuplicates = true,
    ) {
        //
    }

    public function stop(): void
    {
        $this->stop = true;
    }

    public function bypass(): void
    {
        $this->bypass = true;
    }

    public function getIterator(): Traversable
    {
        $hasFilterApplied = isset($this->filterCallback);

        if (!$hasFilterApplied) {
            $this->filterCallback = fn ($value, $key, $iterator) => true;
        }

        try {
            $total = 0;
            $cursor = '0';
            return new IteratorIterator(new CallbackFilterIterator((function () use (&$cursor, &$total) {
                do {
                    [$cursor, $keys] = $this->redis()->scan(
                        $cursor,
                        $this->pattern ? (string) $this->pattern : null,
                        is_numeric($this->limit) ? (string) $this->limit : null,
                        $this->type,
                    );

                    foreach ($keys as $key) {
                        if ($this->limit < ++$total) {
                            break 2;
                        }

                        if ($this->withoutDuplicates && in_array($key, $this->cache, true)) {
                            continue;
                        }

                        if ($this->bypass) {
                            $this->bypass = false;
                            continue 2;
                        } elseif ($this->stop) {
                            break 2;
                        }

                        yield $key => (new ScannedValue(
                            $key,
                            $cursor,
                            $total,
                            $this->connectionName,
                            $keys
                        ));

                        $this->cache[] = $key;
                    }
                } while ($cursor !== '0' && $total < $this->limit && !$this->stop);
            })(), $this->filterCallback));
        } finally {
            $this->cache = [];

            if (!$hasFilterApplied) {
                unset($this->filterCallback);
            }
        }
    }

    public function filter(Closure $callback): static
    {
        $clone = clone $this;
        $clone->filterCallback = $callback;

        return $clone;
    }

    public function withLimit(int $limit): static
    {
        $clone = clone $this;
        $clone->limit = $limit;

        return $clone;
    }

    public function withPattern(string $pattern): static
    {
        $clone = clone $this;
        $clone->pattern = $pattern;

        return $clone;
    }

    public function withType(string $type): static
    {
        $clone = clone $this;
        $clone->type = $type;

        return $clone;
    }

    public function withConnection(string $connection): static
    {
        $clone = clone $this;
        $clone->connectionName = $connection;

        return $clone;
    }

    /** @return \Redis|\Predis\Client */
    private function redis()
    {
        return app('redis')->connection($this->connectionName ?? config('redis-scanner.connection', 'default'))->client();
    }
}
