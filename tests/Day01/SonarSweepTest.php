<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day01;

use PHPUnit\Framework\TestCase;

class SonarSweepTest extends TestCase
{
    private const EXAMPLE = [199, 200, 208, 210, 200, 207, 240, 269, 260, 263];

    public function testPart1(): void
    {
        $sonar_sweep = new SonarSweep();

        self::assertSame(7, $sonar_sweep->countIncreasingDepths(self::EXAMPLE));
    }

    public function testPart2(): void
    {
        $sonar_sweep = new SonarSweep();

        self::assertSame(5, $sonar_sweep->countIncreasingDepthsUsingSlidingWindow(self::EXAMPLE));
    }
}
