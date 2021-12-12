<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day12;

use PHPUnit\Framework\TestCase;

class PathTest extends TestCase
{
    public function testPart1And2(): void
    {
        $path = new Path();

        $input = explode(PHP_EOL, "start-A
start-b
A-c
A-b
b-d
A-end
b-end");

        self::assertSame(10, $path->part1($input));

        self::assertSame(36, $path->part2($input));
    }
}
