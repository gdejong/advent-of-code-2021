<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day15;

use PHPUnit\Framework\TestCase;

class CaveTest extends TestCase
{
    public function testPart1(): void
    {
        $input = explode(PHP_EOL, "1163751742
1381373672
2136511328
3694931569
7463417111
1319128137
1359912421
3125421639
1293138521
2311944581");

        $cave = new Cave();

        self::assertSame(40, $cave->part1($input));
    }
}
