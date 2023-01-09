<?php

declare(strict_types=1);

namespace Cyclone\Extend;

use Cyclone\Extend\Annotations\CycloneCommand;
use ZM\Annotation\AnnotationMap;
use ZM\Annotation\OneBot\BotCommand;
use ZM\Annotation\OneBot\CommandArgument;
use ZM\Annotation\OneBot\CommandHelp;

class CommandConveyor
{
    public function __invoke(CycloneCommand $cycloneCommand): bool
    {
        [$botCommand, $commandArguments, $commandHelp] = $this->convert($cycloneCommand);
        AnnotationMap::loadAnnotationMap([
            $cycloneCommand->class => [
                $cycloneCommand->method => [
                    $botCommand,
                    ...$commandArguments,
                    $commandHelp,
                ],
            ],
        ]);
        AnnotationMap::loadAnnotationList([
            BotCommand::class => [$botCommand],
            CommandArgument::class => $commandArguments,
            CommandHelp::class => [$commandHelp],
        ]);
        logger()->info("Registered command {$cycloneCommand->class}::{$cycloneCommand->method}");
        dump($botCommand);
        return true;
    }

    /**
     * @return array [BotCommand, CommandArgument[], CommandHelp]
     */
    public function convert(CycloneCommand $cycloneCommand): array
    {
        $name = explode(' ', $cycloneCommand->name)[0];
        $botCommand = BotCommand::make(
            name: $name,
            match: $name,
            alias: [$cycloneCommand->alias],
        )->on([resolve($cycloneCommand->class), $cycloneCommand->method]);
        $commandHelp = CommandHelp::make(
            description: $cycloneCommand->description,
            usage: $cycloneCommand->usage,
            example: $cycloneCommand->example,
        );
        $commandArguments = $this->parseArguments($cycloneCommand->name);
        foreach ($commandArguments as $commandArgument) {
            $botCommand->withArgumentObject($commandArgument);
        }
        return [$botCommand, $commandArguments, $commandHelp];
    }

    private function parseArguments(string $command): array
    {
        $arguments = [];
        $command = trim($command);
        $command = preg_replace('/\s+/', ' ', $command);
        $command = explode(' ', $command);
        foreach ($command as $arg) {
            if (preg_match('/^<(.+)>$/', $arg, $matches)) {
                $arguments[] = new CommandArgument(
                    name: $matches[1],
                    description: '',
                    required: true,
                );
            } elseif (preg_match('/^\[(.+)]$/', $arg, $matches)) {
                $arguments[] = new CommandArgument(
                    name: $matches[1],
                    description: '',
                    required: false,
                );
            }
        }
        return $arguments;
    }
}
