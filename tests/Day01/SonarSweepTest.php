<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day01;

use PHPUnit\Framework\TestCase;

class SonarSweepTest extends TestCase
{
    public function testPart1(): void
    {
        $input = [199, 200, 208, 210, 200, 207, 240, 269, 260, 263];
        $sonar_sweep = new SonarSweep();

        self::assertSame(7, $sonar_sweep->countIncreasingDepths($input));
    }
}
