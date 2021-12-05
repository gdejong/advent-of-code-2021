<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day05;

use PHPUnit\Framework\TestCase;

class GridTest extends TestCase
{
    public function testPart1()
    {
        $input = explode(PHP_EOL, "0,9 -> 5,9
8,0 -> 0,8
9,4 -> 3,4
2,2 -> 2,1
7,0 -> 7,4
6,4 -> 2,0
0,9 -> 2,9
3,4 -> 1,4
0,0 -> 8,8
5,5 -> 8,2");

        $grid = new Grid();

        self::assertSame(5, $grid->part1($input));
    }
}
