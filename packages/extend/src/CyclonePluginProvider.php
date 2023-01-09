<?php

declare(strict_types=1);

namespace Cyclone\Extend;

use Cyclone\Extend\Annotations\CycloneCommand;
use Cyclone\Extend\Commander\ExpressionParser;
use ZM\Annotation\AnnotationParser;
use ZM\Annotation\Framework\Init;

abstract class CyclonePluginProvider
{
    protected CyclonePlugin $plugin;

    public function __construct()
    {
        $this->plugin = $this->newPlugin();
        $this->plugin->setBasePath($this->getPluginBaseDir());
        $this->configure($this->plugin);
        RichLog::$plugin = $this->plugin->shortName();
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

        foreach ($this->plugin->configFiles as $configFile) {
            $this->publish(
                $this->plugin->basePath($configFile),
                SOURCE_ROOT_DIR . DIRECTORY_SEPARATOR . $configFile
            );
        }

        $this->startParsing();
        RichLog::log([
            'Plugin',
            $this->plugin->shortName(),
            'Loaded',
        ], [1]);
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

    protected function getPluginNamespace(): string
    {
        return (new \ReflectionClass(static::class))->getNamespaceName();
    }

    protected function startParsing(): void
    {
        $parser = new AnnotationParser(false);
        $parser->addPsr4Path($this->plugin->basePath('src'), $this->getPluginNamespace());
        $parser->addSpecialParser(CycloneCommand::class, new CommandConveyor(new ExpressionParser()));
        $parser->parse();
    }
}
