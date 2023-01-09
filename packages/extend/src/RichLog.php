<?php

declare(strict_types=1);

namespace Cyclone\Extend;

use function Termwind\render;

class RichLog
{
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
        render(
            <<<HTML
<div class="space-x-1">
    <span class="bg-violet-600 px-1">Cyclone</span>
    {$output}
</div>
HTML
        );
    }
}
