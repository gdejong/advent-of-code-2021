<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day17;

use PHPUnit\Framework\TestCase;

class ProbeTest extends TestCase
{
    public function testPart1(): void
    {
        $probe = new Probe();

        $input = "target area: x=20..30, y=-10..-5";

        self::assertSame(45, $probe->part1($input));
    }
}
