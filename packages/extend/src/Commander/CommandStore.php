<?php

declare(strict_types=1);

namespace Cyclone\Extend\Commander;

final class CommandStore
{
    private static array $commands = [];

    public static function addCommand(Command $command): void
    {
        self::$commands[$command->name] = $command;
    }

    public static function getCommand(string $name): ?Command
    {
        return self::$commands[$name] ?? null;
    }

    public static function getCommands(): array
    {
        return self::$commands;
    }
}
