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
        return $this->solve($input, 10);
    }

    /**
     * @param array<string> $input
     */
    public function part2(array $input): int
    {
        return $this->solve($input, 40);
    }

    /**
     * @param array<string> $input
     */
    public function solve(array $input, int $iterations): int
    {
        [$polymer_template, $pair_insertion_rules] = $this->parseInput($input);
        $first_character = $polymer_template[0];

        $len = strlen($polymer_template);
        /** @var array<string, int> $pairs */
        $pairs = [];

        // Create the pairs first
        for ($i = 0; $i < $len - 1; $i++) {
            $new_pair = $polymer_template[$i] . $polymer_template[$i + 1];
            if (isset($pairs[$new_pair])) {
                $pairs[$new_pair]++;
            } else {
                $pairs[$new_pair] = 1;
            }
        }

        for ($i = 0; $i < $iterations; $i++) {
            $pairs = $this->apply($pair_insertion_rules, $pairs);
        }

        $final_count = [];
        /**
         * Start by counting the very first character of the original template.
         * Further counting is done by taking the second part of a pair.
         */
        $final_count[$first_character] = 1;
        foreach ($pairs as $pair => $count) {
            $second_part_of_pair = $pair[1];
            if (!isset($final_count[$second_part_of_pair])) {
                $final_count[$second_part_of_pair] = $count;
            } else {
                $final_count[$second_part_of_pair] += $count;
            }
        }

        return max($final_count) - min($final_count);
    }

    /**
     * @param array<string> $pair_insertion_rules
     * @param array<string, int> $pairs
     *
     * @return array<string, int>
     */
    private function apply(array $pair_insertion_rules, array $pairs): array
    {
        foreach ($pairs as $pair => $count) {
            // Pair: NN
            // Left new pair: NC
            // Right new pair: CN
            $left_new_pair = $pair[0] . $pair_insertion_rules[$pair];
            $right_new_pair = $pair_insertion_rules[$pair] . $pair[1];

            if (isset($pairs[$left_new_pair])) {
                $pairs[$left_new_pair] += $count;
            } else {
                $pairs[$left_new_pair] = $count;
            }
            if (isset($pairs[$right_new_pair])) {
                $pairs[$right_new_pair] += $count;
            } else {
                $pairs[$right_new_pair] = $count;
            }

            // Remove the pair that was just split into two new pairs
            $pairs[$pair] -= $count;
            if ($pairs[$pair] < 0) {
                throw new LogicException("value should not become negative");
            }
            if ($pairs[$pair] === 0) {
                unset($pairs[$pair]);
            }
        }

        return $pairs;
    }
}
