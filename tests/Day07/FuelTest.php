<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day07;

use PHPUnit\Framework\TestCase;

class FuelTest extends TestCase
{
    public function testPart1And2(): void
    {
        $input = "16,1,2,0,4,2,7,1,2,14";

        $fuel = new Fuel();

        self::assertSame(37, $fuel->part1($input));

        self::assertSame(168, $fuel->part2($input));
    }
}
