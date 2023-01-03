<?php

namespace Sxy\I18n;

use OneBot\Config\Loader\DelegateLoader;
use OneBot\Config\Repository;
use ZM\Config\ZMConfig;

class TranslationProvider
{
    private ZMConfig $holder;

    public function __construct()
    {
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
    }

    public function setLocale(string $locale): void
    {
        $this->holder->set('locale', $locale);
    }

    public function get(string $key, string $locale = null): string
    {
        $locale = $locale ?: (string)$this->holder->get('locale');
        return $this->holder->get("{$locale}.{$key}", $key);
    }
}
