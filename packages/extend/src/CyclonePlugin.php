<?php

declare(strict_types=1);

namespace Cyclone\Extend;

use ZM\Plugin\ZMPlugin;

class CyclonePlugin extends ZMPlugin
{
    public string $name;

    public array $configFiles = [];

    public bool $hasTranslations = false;

    public string $basePath;

    public function __construct()
    {
        parent::__construct('');
    }

    public function name(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function shortName(): string
    {
        return $this->name;
    }

    public function hasConfigFile($configFile = null): static
    {
        $name = $configFile ?? $this->shortName();

        if (!is_array($name)) {
            $name = [$name];
        }

        $this->configFiles = $name;
        return $this;
    }

    public function hasTranslations(): static
    {
        $this->hasTranslations = true;
        return $this;
    }

    public function basePath(string $directory = null): string
    {
        if ($directory === null) {
            return $this->basePath;
        }

        return $this->basePath . DIRECTORY_SEPARATOR . ltrim($directory, DIRECTORY_SEPARATOR);
    }

    public function setBasePath(string $basePath): static
    {
        $this->basePath = $basePath;
        $this->dir = $basePath . DIRECTORY_SEPARATOR . 'src';
        return $this;
    }
}
