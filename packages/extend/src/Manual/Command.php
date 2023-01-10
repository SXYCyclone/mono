<?php

declare(strict_types=1);

namespace Cyclone\Extend\Manual;

use Cyclone\Extend\Annotations\CycloneCommand;
use Cyclone\Extend\Commander\CommandStore;
use ZM\Annotation\OneBot\BotCommand;
use ZM\Context\BotContext;

class Command
{
    #[CycloneCommand('help [command]')]
    public function helpEntry(?string $command, Generator $generator, BotContext $context): void
    {
        if ($command === null) {
            $help = $generator->generateList(CommandStore::getCommands());
            $context->reply(implode("\n", $help));
        } elseif ($cmd = CommandStore::getCommand($command)) {
            $help = $generator->generate($cmd);
            $context->reply(implode("\n", $help));
        }
    }

    #[BotCommand(name: 'help', match: 'help', alias: ['帮助'])]
    public function disableBuiltinHelp(): void
    {
    }
}
