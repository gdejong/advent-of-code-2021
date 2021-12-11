<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day10;

use PHPUnit\Framework\TestCase;

class SyntaxTest extends TestCase
{
    public function testPart1And2(): void
    {
        $input = explode(PHP_EOL, "[({(<(())[]>[[{[]{<()<>>
[(()[<>])]({[<{<<[]>>(
{([(<{}[<>[]}>{[]{[(<()>
(((({<>}<{<{<>}{[]{[]{}
[[<[([]))<([[{}[[()]]]
[{[{({}]{}}([{[{{{}}([]
{<[[]]>}<{[{[{[]{()[[[]
[<(<(<(<{}))><([]([]()
<{([([[(<>()){}]>(<<{{
<{([{{}}[<[[[<>{}]]]>[]]");

        $syntax = new Syntax();

        self::assertSame(26397, $syntax->part1($input));

        self::assertSame(288957, $syntax->part2($input));
    }
}
