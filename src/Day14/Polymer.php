<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day14;

use LogicException;

class Polymer
{
    /**
     * @param array<string> $input
     *
     * @return array{0: string, 1: array<string>}
     */
    private function parseInput(array $input): array
    {
        $polymer_template = $input[0];
        unset($input[0]);

        $pair_insertion_rules = [];
        foreach ($input as $line) {
            if (trim($line) === "") {
                continue;
            }

            preg_match("/([A-Z]{2})\s*->\s*([A-Z])/", $line, $match);
            [, $pair, $becomes] = $match;
            if (isset($pair_insertion_rules[$pair])) {
                throw new LogicException("duplicate pair");
            }
            $pair_insertion_rules[$pair] = $becomes;
        }

        return [$polymer_template, $pair_insertion_rules];
    }

    /**
     * @param array<string> $input
     */
    public function part1(array $input): int
    {
        [$polymer_template, $pair_insertion_rules] = $this->parseInput($input);

        for ($i = 0; $i < 10; $i++) {
            $polymer_template = $this->apply($polymer_template, $pair_insertion_rules);
        }

        // Mode:
        // 0 - an array with the byte-value as key and the frequency of every byte as value.
        // 1 - same as 0 but only byte-values with a frequency greater than zero are listed.
        /** @var non-empty-array<int> $chars */
        $chars = count_chars($polymer_template, 1);

        return max($chars) - min($chars);
    }

    /**
     * @param array<string> $rules
     */
    private function apply(string $input, array $rules): string
    {
        $len = strlen($input);
        $pairs = [];

        // Create the pairs first
        for ($i = 0; $i < $len - 1; $i++) {
            $pairs[] = $input[$i] . $input[$i + 1];
        }

        $new_polymer = "";
        foreach ($pairs as $pair) {
            $new_polymer .= $pair[0] . $rules[$pair];
        }

        $last_character = substr($input, -1);

        return $new_polymer . $last_character;
    }
}
