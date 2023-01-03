<?php

namespace Sxy\I18n;

use ZM\Context\BotContext;

class LocaleDecider
{
    public function decideFromBotContext(BotContext $context): string
    {
        $id = $context->getEvent()->getUserId();
        return kv('i18n')->get($id, 'en');
    }
}
