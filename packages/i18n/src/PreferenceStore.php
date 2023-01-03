<?php

declare(strict_types=1);

namespace Cyclone\I18n;

use OneBot\Util\Singleton;
use Psr\SimpleCache\CacheInterface;

class PreferenceStore
{
    use Singleton;

    public function __construct(
        private readonly CacheInterface $store,
    ) {
    }

    public function get(string $key, string $default = null): string
    {
        return $this->store->get($key, $default);
    }

    public function set(string $key, string $value): void
    {
        $this->store->set($key, $value);
    }
}
