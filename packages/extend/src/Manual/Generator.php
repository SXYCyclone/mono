<?php

declare(strict_types=1);

namespace Cyclone\Extend\Manual;

use Cyclone\Extend\Commander\InputArgument;

class Generator
{
    public static string $template = <<<'EOT'
{description_title}
  {description}

{usage_title}
  {usage}

{arguments_title}
  {arguments}
EOT;

    public function generateList(array $commands): array
    {
        $title = trans('help.title.list');
        $list = [];
        foreach ($commands as $command) {
            /* @var \Cyclone\Extend\Commander\Command $command */
            $list[$command->getBelongingPackage()][] = $command;
        }
        $help = [$title];
        foreach ($list as $package => $pkg_commands) {
            $help[] = " {$package}";
            foreach ($pkg_commands as $command) {
                $help[] = "  {$command->name} - " . trans("cmd.{$command->name}.description");
            }
        }
        return $help;
    }

    public function generate(\Cyclone\Extend\Commander\Command $command): array
    {
        $name = $command->name;
        $arguments = $command->arguments;

        $template = self::$template;

        $template = str_replace([
            '{description_title}',
            '{usage_title}',
            '{arguments_title}',
        ], [
            trans('help.title.description'),
            trans('help.title.usage'),
            trans('help.title.arguments'),
        ], $template);

        $description = trans("cmd.{$name}.description");
        $usage = ($t = trans("cmd.{$name}.usage")) === "cmd.{$name}.usage" ? $command->signature : $t;
        $arguments = array_map([$this, 'getArgumentLine'], $arguments);
        $arguments = implode("\n  ", $arguments);
        $template = str_replace([
            '{description}',
            '{usage}',
            '{arguments}',
        ], [
            $description,
            $usage,
            $arguments,
        ], $template);

        return explode("\n", $template);
    }

    private function getArgumentLine(InputArgument $argument): string
    {
        $template = '{name} {description} {default}';
        $name = $argument->getName();
        $description = trans("arg.{$name}.description");
        $default = $argument->getDefault() ? $this->stringify($argument->getDefault()) : '';
        return str_replace([
            '{name}',
            '{description}',
            '{default}',
        ], [
            $name,
            $description,
            $default,
        ], $template);
    }

    private function stringify($item): string
    {
        switch (true) {
            case is_callable($item):
                if (is_array($item)) {
                    if (is_object($item[0])) {
                        return get_class($item[0]) . '@' . $item[1];
                    }
                    return $item[0] . '::' . $item[1];
                }
                return 'closure';
            case is_string($item):
                return $item;
            case is_array($item):
                return 'array' . (extension_loaded('json') ? json_encode($item, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_LINE_TERMINATORS) : '');
            case is_object($item):
                return get_class($item);
            case is_resource($item):
                return 'resource(' . get_resource_type($item) . ')';
            case is_null($item):
                return 'null';
            case is_bool($item):
                return $item ? 'true' : 'false';
            case is_float($item):
            case is_int($item):
                return (string) $item;
            default:
                return 'unknown';
        }
    }
}
