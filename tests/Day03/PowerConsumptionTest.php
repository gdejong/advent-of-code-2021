<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day03;

use PHPUnit\Framework\TestCase;

class PowerConsumptionTest extends TestCase
{
    private const TEST_INPUT = [
        "00100",
        "11110",
        "10110",
        "10111",
        "10101",
        "01111",
        "00111",
        "11100",
        "10000",
        "11001",
        "00010",
        "01010"
    ];

    public function testPart1(): void
    {
        $power = new PowerConsumption();

        self::assertSame(198, $power->part1(self::TEST_INPUT));
    }

    public function testPart2(): void
    {
        $power = new PowerConsumption();

        self::assertSame(230, $power->part2(self::TEST_INPUT));
    }
}
