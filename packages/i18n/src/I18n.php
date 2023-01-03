<?php

namespace Sxy\I18n;

use ZM\Annotation\Framework\Init;
use ZM\Plugin\CommandManual\CommandManualPlugin;

class I18n
{
    private TranslationProvider $translationProvider;
    private I18nManualFactory $manualFactory;

    public function __construct()
    {
        $decider = new LocaleDecider();
        $this->translationProvider = new TranslationProvider();
        $this->manualFactory = new I18nManualFactory($this->translationProvider, $decider);

        CommandManualPlugin::addManualFactory([$this->manualFactory, 'make']);
    }

    #[Init]
    public function onInit(): void
    {
        // just to trigger the constructor
    }
}
