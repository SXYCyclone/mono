<?php

declare(strict_types=1);

namespace Cyclone\I18n\Commands;

use Cyclone\I18n\PreferenceStore;
use ZM\Annotation\OneBot\BotCommand;
use ZM\Annotation\OneBot\CommandArgument;
use ZM\Annotation\OneBot\CommandHelp;
use ZM\Context\BotContext;

class Locale
{
    #[BotCommand('locale', 'locale')]
    #[CommandArgument('locale', 'cmd.locale.arg.locale', required: true)]
    #[CommandHelp('cmd.locale.help.desc', 'cmd.locale.help.usage', 'cmd.locale.help.example')]
    public function setLocale(BotContext $context): void
    {
        $target = $context->getParam('locale');
        $id = $context->getEvent()->getUserId();
        PreferenceStore::getInstance()->set($id, $target);
    }
}
