<?php

declare(strict_types=1);

namespace Cyclone\Extend;

use function Termwind\render;

class RichLog
{
    public static string $plugin;

    public static function log(array $content, array $highlights = []): void
    {
        $output = '';
        foreach ($content as $index => $line) {
            if (in_array($index, $highlights, true)) {
                $output .= "<span class=\"text-green-500\">{$line}</span>";
            } else {
                $output .= "<span class=\"text-gray-500\">{$line}</span>";
            }
        }

        if (self::$plugin) {
            $l = (10 - strlen(self::$plugin)) / 2;
            $r = 10 - $l - strlen(self::$plugin);
            $p = "<span class='bg-fuchsia-800 pl-{$l} pr-{$r}'>" . self::$plugin . '</span>';
        } else {
            $p = '';
        }

        render(
            <<<HTML
<div class="space-x-1">
    <span class="bg-purple-800 px-1">Cyclone</span>
    {$p}
    {$output}
</div>
HTML
        );
    }
}
