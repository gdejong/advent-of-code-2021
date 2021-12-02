<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day02;

use PHPUnit\Framework\TestCase;

class SubmarinePositionTest extends TestCase
{
    public function testPart1(): void
    {
        $pos = new SubmarinePosition();

        $route = [
            ["forward", 5],
            ["down", 5],
            ["forward", 8],
            ["up", 3],
            ["down", 8],
            ["forward", 2],
        ];

        self::assertSame(150, $pos->calculatePart1($route));
    }

    public function testPart2(): void
    {
        $pos = new SubmarinePosition();

        $route = [
            ["forward", 5],
            ["down", 5],
            ["forward", 8],
            ["up", 3],
            ["down", 8],
            ["forward", 2],
        ];

        self::assertSame(900, $pos->calculatePart2($route));
    }
}
