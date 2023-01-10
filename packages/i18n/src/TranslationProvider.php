<?php

declare(strict_types=1);

namespace Cyclone\I18n;

use OneBot\Config\Loader\DelegateLoader;
use OneBot\Config\Repository;
use OneBot\Util\Singleton;
use ZM\Config\ZMConfig;
use ZM\Context\BotContext;
use ZM\Store\FileSystem;

class TranslationProvider
{
    use Singleton;

    private ZMConfig $holder;

    private LocaleDecider $decider;

    public function __construct()
    {
        FileSystem::createDir(SOURCE_ROOT_DIR . '/lang');
        $this->holder = new ZMConfig('lang', [
            'source' => [
                'extensions' => ['php'],
                'paths' => [
                    SOURCE_ROOT_DIR . '/lang',
                ],
            ],
            'repository' => [
                Repository::class,
                [],
            ],
            'loader' => [
                DelegateLoader::class,
                [],
            ],
        ]);
        $this->decider = new LocaleDecider();
    }

    public function get(string $key, string $locale = null): string
    {
        $locale = $locale ?: $this->decider->decideFromBotContext(resolve(BotContext::class));
        $t = $this->holder->get("{$locale}.{$key}", $key);
        if ($t === $key) {
            logger()->warning("translation key '{$key}' not found in locale '{$locale}'");
        }
        return $t;
    }

    public function addPackage(string $path): void
    {
        $this->holder->addConfigPath($path);
    }

    public function refresh(): void
    {
        $this->holder->reload();
    }
}
