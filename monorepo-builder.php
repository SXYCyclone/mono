<?php

declare(strict_types=1);

use Symplify\MonorepoBuilder\ComposerJsonManipulator\ValueObject\ComposerJsonSection;
use Symplify\MonorepoBuilder\Config\MBConfig;

return static function (MBConfig $config): void {
    $config->packageDirectories([
        __DIR__ . '/packages',
    ]);

    $config->dataToAppend([
        ComposerJsonSection::REQUIRE => [
            'php' => '^8.1',
            'zhamao/framework' => '^3',
        ],
        ComposerJsonSection::MINIMUM_STABILITY => 'dev',
        ComposerJsonSection::PREFER_STABLE => true,
        ComposerJsonSection::SCRIPTS => [
            'post-autoload-dump' => 'tools/captainhook install -f -s',
            'analyse' => 'tools/phpstan analyse -c phpstan.neon',
            'cs-fix' => 'PHP_CS_FIXER_FUTURE_MODE=1 tools/php-cs-fixer fix',
            'test' => 'tools/phpunit --no-coverage',
        ]
    ]);

    $config->dataToRemove([
        ComposerJsonSection::REQUIRE => [
            'php' => '*',
        ],
    ]);
};
