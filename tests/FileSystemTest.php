<?php

namespace CrazyFactory\Utils\Tests;

use CrazyFactory\Utils\FileSystem;
use PHPUnit\Framework\TestCase;

class FileSystemTest extends TestCase
{
    /** @var null|string */
    static $cachePath;

    public static function setUpBeforeClass()
    {
        self::$cachePath = __DIR__ . '/.cache';

        if (file_exists(self::$cachePath)) {
            rmdir(self::$cachePath);
        }
    }

    public function testMkdir()
    {
        $this->assertDirectoryNotExists(self::$cachePath);

        $this->assertTrue(FileSystem::mkdir(self::$cachePath));

        $this->assertDirectoryExists(self::$cachePath);

        $this->assertTrue(FileSystem::mkdir(self::$cachePath));

        rmdir(self::$cachePath);
    }

    public function testRm()
    {
        $path = self::$cachePath . '/test/test';
        $filePath = $path . '/test.txt';

        mkdir($path, 0777, true);

        fopen($filePath, "w");

        $this->assertDirectoryExists($path);
        $this->assertFileExists($filePath);

        $this->assertTrue(FileSystem::rm(self::$cachePath));

        $this->assertDirectoryNotExists(self::$cachePath);
    }

}
