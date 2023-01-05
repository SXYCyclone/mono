<?php

declare(strict_types=1);

namespace Cyclone\Extend;

use ZM\Annotation\Framework\Init;

abstract class CyclonePluginProvider
{
    protected CyclonePlugin $plugin;

    public function __construct()
    {
        $this->plugin = $this->newPlugin();
        $this->plugin->setBasePath($this->getPluginBaseDir());
        $this->configure($this->plugin);
    }

    abstract public function configure(CyclonePlugin $plugin): void;

    #[Init]
    public function onInit(): void
    {
        if ($this->plugin->hasTranslations) {
            $this->publish(
                $this->plugin->basePath('lang'),
                SOURCE_ROOT_DIR . '/lang'
            );
        }
        logger()->info('CyclonePlugin ' . static::class . ' is loaded.');
    }

    public function publishes(array $publishes): void
    {
        foreach ($publishes as $source => $destination) {
            Publisher::publish($source, $destination);
        }
    }

    public function publish(string $source, string $destination, bool $force = false): void
    {
        Publisher::publish($source, $destination, $force);
    }

    public function newPlugin(): CyclonePlugin
    {
        return new CyclonePlugin();
    }

    protected function getPluginBaseDir(): string
    {
        $reflector = new \ReflectionClass(static::class);
        return dirname($reflector->getFileName(), 2);
    }
}
