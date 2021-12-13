<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day13;

use PHPUnit\Framework\TestCase;

class FoldTest extends TestCase
{
    public function testPart1(): void
    {
        $input = explode(PHP_EOL, "6,10
0,14
9,10
0,3
10,4
4,11
6,0
6,12
4,1
0,13
10,12
3,4
3,0
8,4
1,10
2,14
8,10
9,0

fold along y=7
fold along x=5");

        $fold = new Fold();

        self::assertSame(17, $fold->part1($input));
    }
}
