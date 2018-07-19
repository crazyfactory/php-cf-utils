<?php

namespace CrazyFactory\Utils\Tests;


use CrazyFactory\Utils\Format;
use PHPUnit\Framework\TestCase;

class FormatTest extends TestCase
{
    public function provideTestTimeElapsed() {
        return [
            [50, "50s"],
            [70, "01m 10s"],
            [3696, "01h 01m 36s"],
            [7200, "02h 00m 00s"],
            [null, ""]
        ];
    }

    /**
     * @dataProvider provideTestTimeElapsed
     */
    public function testGetDurationFormatted($seconds, $expected) {
        $this->assertEquals($expected, Format::timeElapsed($seconds));
    }
}
