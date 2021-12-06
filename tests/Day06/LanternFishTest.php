<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day06;

use PHPUnit\Framework\TestCase;

class LanternFishTest extends TestCase
{
    public function testPart1(): void
    {
        $input = "3,4,3,1,2";

        $fish = new LanternFish();

        self::assertSame(5934, $fish->part1($input));
    }
}
