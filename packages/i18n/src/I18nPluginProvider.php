<?php

declare(strict_types=1);

namespace Cyclone\I18n;

use Cyclone\Extend\CyclonePlugin;
use Cyclone\Extend\CyclonePluginProvider;

class I18nPluginProvider extends CyclonePluginProvider
{
    public function configure(CyclonePlugin $plugin): void
    {
        $plugin->name('i18n');
    }
}
