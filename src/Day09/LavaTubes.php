<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day09;

class LavaTubes
{
    /**
     * @param array<string> $input
     */
    public function part1(array $input): int
    {
        // Parse the input
        /** @var array<array<int>> $floor */
        $floor = [];

        foreach ($input as $level => $item) {
            $numbers = array_map(static function (string $num) {
                return (int)$num;
            }, str_split($item));

            $floor[$level] = $numbers;
        }

        // Find all low points.
        $low_points = [];
        /** @var int $y */
        foreach ($floor as $y => $row) {
            /** @var int $x */
            foreach ($row as $x => $number) {
                // find the other (max 4) numbers.
                /** @var non-empty-array<int> $adjacent_locations */
                $adjacent_locations = [];

                // To the right of the current position.
                if (isset($floor[$y][$x + 1])) {
                    $adjacent_locations[] = $floor[$y][$x + 1];
                }
                // To the left of the current position.
                if (isset($floor[$y][$x - 1])) {
                    $adjacent_locations[] = $floor[$y][$x - 1];
                }
                // To the top of the current position.
                if (isset($floor[$y - 1][$x])) {
                    $adjacent_locations[] = $floor[$y - 1][$x];
                }
                // To the bottom of the current position.
                if (isset($floor[$y + 1][$x])) {
                    $adjacent_locations[] = $floor[$y + 1][$x];
                }

                // Find the locations that are lower than any of its adjacent locations
                if ($number < min($adjacent_locations)) {
                    $low_points[] = $number;
                }
            }
        }

        // Calculate the risk level
        $risk_level = 0;
        foreach ($low_points as $low_point) {
            $risk_level += $low_point + 1;
        }

        return $risk_level;
    }
}
