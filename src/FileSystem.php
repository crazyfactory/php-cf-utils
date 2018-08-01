<?php

namespace CrazyFactory\Utils;

class FileSystem
{

    /**
     * Recursively removes files and directories
     *
     * @param string $path
     * @return bool
     */
    public static function rm(string $path): bool
    {
        if (!file_exists($path)) {
            return true;
        }

        if (is_dir($path)) {
            foreach (array_diff(scandir($path), ['.', '..']) as $filename) {
                static::rm($path . '/' . $filename);
            }

            return rmdir($path);
        }
        else {
            return unlink($path);
        }
    }

    /**
     * Creates a directory recursively and sets directory permissions to 777
     *
     * @param string $path
     * @param int $permissions
     * @return bool
     */
    public static function mkdir(string $path, $permissions = 777): bool
    {
        if (file_exists($path)) {
            return true;
        }

        return mkdir($path, $permissions, true);
    }

}
