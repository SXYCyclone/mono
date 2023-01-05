<?php

declare(strict_types=1);

namespace Cyclone\I18n;

use Cyclone\Extend\CyclonePlugin;
use Cyclone\Extend\CyclonePluginProvider;
use ZM\Plugin\CommandManual\CommandManualPlugin;

class I18nPluginProvider extends CyclonePluginProvider
{
    private TranslationProvider $translationProvider;

    private I18nManualFactory $manualFactory;

    public function configure(CyclonePlugin $plugin): void
    {
        $plugin->name('i18n');

        $decider = new LocaleDecider(PreferenceStore::getInstance(kv('i18n')));
        $this->translationProvider = new TranslationProvider();
        $this->manualFactory = new I18nManualFactory($this->translationProvider, $decider);

        CommandManualPlugin::addManualFactory([$this->manualFactory, 'make']);
    }
}
