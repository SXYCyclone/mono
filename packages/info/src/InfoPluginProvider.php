<?php

declare(strict_types=1);

namespace Cyclone\Info;

use Cyclone\Extend\CyclonePlugin;
use Cyclone\Extend\CyclonePluginProvider;

class InfoPluginProvider extends CyclonePluginProvider
{
    public function configure(CyclonePlugin $plugin): void
    {
        $plugin->name('info')
            ->hasTranslations();
    }
}
