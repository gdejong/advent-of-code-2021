<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day10;

use LogicException;
use SplStack;

class Syntax
{
    /**
     * @param array<array-key, string> $input
     */
    public function part1(array $input): int
    {
        $valid_chunk_chars = [
            "(" => ")",
            "[" => "]",
            "{" => "}",
            "<" => ">",
        ];

        $open_chars = array_keys($valid_chunk_chars);
        $close_chars = array_values($valid_chunk_chars);

        $invalid = [];
        foreach ($input as $line) {
            $opened = new SplStack();
            $chars = str_split($line);
            foreach ($chars as $char) {
                if (in_array($char, $open_chars, true)) {
                    // open char
                    $opened->push($char);
                } elseif (in_array($char, $close_chars, true)) {
                    // closing char
                    /** @var string $top */
                    $top = $opened->top();
                    $expected_closing_char = $valid_chunk_chars[$top];
                    if ($char !== $expected_closing_char) {
                        $invalid[] = $char;
                        continue 2;
                    }
                    $opened->pop();
                } else {
                    throw new LogicException("not an open or close char: $char");
                }
            }
        }

        // count it
        $error_score = 0;
        foreach ($invalid as $char) {
            $error_score += match ($char) {
                ")" => 3,
                "]" => 57,
                "}" => 1197,
                ">" => 25137,
            };
        }
        return $error_score;
    }
}