<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day10;

use LogicException;
use SplStack;

class Syntax
{
    private const CHUNK_CHARS = [
        "(" => ")",
        "[" => "]",
        "{" => "}",
        "<" => ">",
    ];

    private function isOpeningChar(string $char): bool
    {
        return in_array($char, array_keys(self::CHUNK_CHARS), true);
    }

    private function isClosingChar(string $char): bool
    {
        return in_array($char, array_values(self::CHUNK_CHARS), true);
    }

    /**
     * @param array<array-key, string> $input
     */
    public function part1(array $input): int
    {
        $invalid = [];
        foreach ($input as $line) {
            $opened = new SplStack();
            $chars = str_split($line);
            foreach ($chars as $char) {
                if ($this->isOpeningChar($char)) {
                    $opened->push($char);
                } elseif ($this->isClosingChar($char)) {
                    /** @var string $top */
                    $top = $opened->top(); // look at the top of the stack, do not pop it yet
                    $expected_closing_char = self::CHUNK_CHARS[$top];
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

    /**
     * @param array<array-key, string> $input
     */
    public function part2(array $input): int
    {
        $completion_strings = [];
        foreach ($input as $line) {
            $opened = new SplStack();
            foreach (str_split($line) as $char) {
                if ($this->isOpeningChar($char)) {
                    $opened->push($char);
                } elseif ($this->isClosingChar($char)) {
                    /** @var string $top */
                    $top = $opened->top(); // look at the top of the stack, do not pop it yet
                    $expected_closing_char = self::CHUNK_CHARS[$top];
                    if ($char !== $expected_closing_char) {
                        continue 2;
                    }
                    $opened->pop();
                } else {
                    throw new LogicException("not an open or close char: $char");
                }

            }
            $count = $opened->count();
            if ($count > 0) {
                $completion_string = "";
                while ($opened->count()) {
                    /** @var string $top */
                    $top = $opened->pop();
                    $completion_string .= self::CHUNK_CHARS[$top];
                }
                $completion_strings[] = $completion_string;
            }
        }

        $score = [];
        foreach ($completion_strings as $completion_string) {
            $score[] = $this->calculateCompletionStringScore($completion_string);
        }

        // Return the middle value
        sort($score);

        return $score[(int)floor(count($score) / 2)];
    }

    private function calculateCompletionStringScore(string $string): int
    {
        $score = 0;

        foreach (str_split($string) as $char) {
            $score *= 5;

            $score += match ($char) {
                ")" => 1,
                "]" => 2,
                "}" => 3,
                ">" => 4,
            };
        }

        return $score;
    }
}