<?php

declare(strict_types=1);

namespace Cyclone\Extend;

class ExtendPluginProvider extends CyclonePluginProvider
{
    public function configure(CyclonePlugin $plugin): void
    {
        $plugin->name('extend')
            ->hasConfigFile('config/cyclone.php')
            ->hasTranslations();
    }
}
