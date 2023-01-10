<?php

declare(strict_types=1);

namespace Cyclone\I18n;

use ZM\Context\BotContext;

class LocaleDecider
{
    private readonly PreferenceStore $store;

    public function __construct()
    {
        $this->store = PreferenceStore::getInstance(kv('i18n'));
    }

    public function decideFromBotContext(BotContext $context): string
    {
        $id = $context->getEvent()->getUserId();
        return $this->store->get($id, 'en');
    }
}
