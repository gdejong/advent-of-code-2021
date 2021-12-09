<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day09;

use PHPUnit\Framework\TestCase;

class LavaTubesTest extends TestCase
{
    public function testPart1(): void
    {
        $input = explode(PHP_EOL, "2199943210
3987894921
9856789892
8767896789
9899965678");

        $lava_tubes = new LavaTubes();

        self::assertSame(15, $lava_tubes->part1($input));
    }
}
