<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day14;

use PHPUnit\Framework\TestCase;

class PolymerTest extends TestCase
{
    public function testPart1(): void
    {
        $polymer = new Polymer();

        $input = explode(PHP_EOL, "NNCB

CH -> B
HH -> N
CB -> H
NH -> C
HB -> C
HC -> B
HN -> C
NN -> C
BH -> H
NC -> B
NB -> B
BN -> B
BB -> N
BC -> B
CC -> N
CN -> C");

        self::assertSame(1588, $polymer->part1($input));
    }
}
