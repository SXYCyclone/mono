<?php

declare(strict_types=1);

namespace Cyclone\Extend\Commander;

class Command
{
    public function __construct(
        public readonly string $name,
        public readonly array $arguments,
        private readonly array $handler,
        public readonly string $signature = '',
    ) {
    }

    public function handle(array $arguments): void
    {
        container()->call($this->handler, $arguments);
    }

    public function getBelongingPackage(): string
    {
        return once(function () {
            $class = $this->handler[0];
            // the second part of class name
            return explode('\\', $class)[1];
        });
    }
}
