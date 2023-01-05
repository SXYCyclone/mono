<?php

declare(strict_types=1);

namespace Cyclone\Extend;

use ZM\Store\FileSystem;

class Publisher
{
    public static function publish(string $source, string $destination, bool $force = false): void
    {
        if (is_dir($source)) {
            self::publishDirectory($source, $destination, $force);
        } else {
            self::publishFile($source, $destination, $force);
        }
    }

    public static function publishDirectory(string $source, string $destination, bool $force = false): void
    {
        FileSystem::createDir($destination);
        $files = FileSystem::scanDirFiles($source);
        foreach ($files as $file) {
            self::publishFile($file, $destination . '/' . basename($file), $force);
        }
    }

    public static function publishFile(string $source, string $destination, bool $force = false): void
    {
        if ($force || !file_exists($destination)) {
            copy($source, $destination);
            logger()->info("Published {$source} to {$destination}");
        }
    }
}
