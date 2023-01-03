<?php

namespace Sxy\I18n\Commands;

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
        kv('i18n')->set($id, $target);
    }
}
