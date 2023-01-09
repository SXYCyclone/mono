<?php

declare(strict_types=1);

namespace Cyclone\Extend;

use Cyclone\Extend\Annotations\CycloneCommand;
use Cyclone\Extend\Commander\Command;
use Cyclone\Extend\Commander\CommandStore;
use Cyclone\Extend\Commander\ExpressionParser;
use ZM\Annotation\AnnotationMap;
use ZM\Annotation\OneBot\BotCommand;
use ZM\Annotation\OneBot\CommandArgument;
use ZM\Annotation\OneBot\CommandHelp;

class CommandConveyor
{
    public function __construct(
        private readonly ExpressionParser $parser,
    ) {
    }

    public function __invoke(CycloneCommand $cycloneCommand): bool
    {
        $parsed = $this->parser->parse($cycloneCommand->expression);
        $command = new Command(
            $parsed['name'],
            $parsed['arguments'],
            [$cycloneCommand->class, $cycloneCommand->method],
        );
        CommandStore::addCommand($command);
//        [$botCommand, $commandArguments, $commandHelp] = $this->convert($cycloneCommand);
//        AnnotationMap::loadAnnotationMap([
//            $cycloneCommand->class => [
//                $cycloneCommand->method => [
//                    $botCommand,
//                    ...$commandArguments,
//                    $commandHelp,
//                ],
//            ],
//        ]);
//        AnnotationMap::loadAnnotationList([
//            BotCommand::class => [$botCommand],
//            CommandArgument::class => $commandArguments,
//            CommandHelp::class => [$commandHelp],
//        ]);
        return true;
    }

    /**
     * @return array [BotCommand, CommandArgument[], CommandHelp]
     */
    public function convert(CycloneCommand $cycloneCommand): array
    {
        $default = config('cyclone.command.default');
        $name = explode(' ', $cycloneCommand->name)[0];
        $botCommand = BotCommand::make(
            name: $name,
            match: $name,
            alias: $cycloneCommand->aliases,
        )->on([resolve($cycloneCommand->class), $cycloneCommand->method]);
        $commandHelp = CommandHelp::make(
            description: $cycloneCommand->description ?: $this->translateDefault($default['description'], ['cmd' => $name]),
            usage: $cycloneCommand->usage ?: $this->translateDefault($default['usage'], ['cmd' => $name]),
            example: $cycloneCommand->example ?: $this->translateDefault($default['example'], ['cmd' => $name]),
        );
        $commandArguments = $this->parseArguments($cycloneCommand->name);
        foreach ($commandArguments as $commandArgument) {
            $botCommand->withArgumentObject($commandArgument);
        }
        return [$botCommand, $commandArguments, $commandHelp];
    }

    private function parseArguments(string $command): array
    {
        $default = config('cyclone.command.default.argument');
        $arguments = [];
        $command = trim($command);
        $command = preg_replace('/\s+/', ' ', $command);
        $command = explode(' ', $command);
        foreach ($command as $arg) {
            if (preg_match('/^<(.+)>$/', $arg, $matches)) {
                $arguments[] = new CommandArgument(
                    name: $matches[1],
                    description: $this->translateDefault($default, ['cmd' => $command[0], 'arg' => $matches[1]]),
                    required: true,
                );
            } elseif (preg_match('/^\[(.+)]$/', $arg, $matches)) {
                $arguments[] = new CommandArgument(
                    name: $matches[1],
                    description: $this->translateDefault($default, ['cmd' => $command[0], 'arg' => $matches[1]]),
                    required: false,
                );
            }
        }
        return $arguments;
    }

    private function translateDefault(string $default, array $args): string
    {
        foreach ($args as $key => $value) {
            $default = str_replace("<{$key}>", $value, $default);
        }
        return $default;
    }
}
