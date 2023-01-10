<?php

declare(strict_types=1);

if (!function_exists('trans')) {
    function trans(string $key, string $locale = null): string
    {
        return \Cyclone\I18n\TranslationProvider::getInstance()->get($key, $locale);
    }
}
