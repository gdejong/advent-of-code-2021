<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day11;

use PHPUnit\Framework\TestCase;

class OctopusTest extends TestCase
{
    public function testPart1And2(): void
    {
        $input = explode(PHP_EOL, "5483143223
2745854711
5264556173
6141336146
6357385478
4167524645
2176841721
6882881134
4846848554
5283751526");

        $octopus = new Octopus();

        self::assertSame(1656, $octopus->part1($input));

        self::assertSame(195, $octopus->part2($input));
    }
}
