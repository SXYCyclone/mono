<?php

declare(strict_types=1);

namespace Cyclone\I18n\Commands;

use Cyclone\Extend\Annotations\CycloneCommand;
use Cyclone\I18n\PreferenceStore;
use ZM\Context\BotContext;

class Locale
{
    #[CycloneCommand('locale locale')]
    public function setLocale(string $locale, BotContext $context): void
    {
        $target = $locale;
        $id = $context->getEvent()->getUserId();
        PreferenceStore::getInstance()->set($id, $target);
        $context->reply('cmd.locale.reply');
    }
}
