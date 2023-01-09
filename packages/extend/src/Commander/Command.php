<?php

declare(strict_types=1);

namespace Cyclone\Extend\Commander;

class Command
{
    public function __construct(
        public readonly string $name,
        public readonly array $arguments,
        private readonly array|\Closure $handler,
    ) {
    }

    public function handle(array $arguments): void
    {
        container()->call($this->handler, $arguments);
    }
}
