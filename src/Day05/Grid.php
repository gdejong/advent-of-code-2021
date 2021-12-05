<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day05;

class Grid
{
    /**
     * @param array<array-key, string> $input
     *
     * @return array<array<int>>
     */
    private function parseInput(array $input): array
    {
        $points = [];
        foreach ($input as $item) {
            preg_match_all('/\d+/', trim($item), $matches);
            $x1 = (int)$matches[0][0];
            $y1 = (int)$matches[0][1];
            $x2 = (int)$matches[0][2];
            $y2 = (int)$matches[0][3];

            // For now, only consider horizontal and vertical lines: lines where either x1 = x2 or y1 = y2.
            if ($x1 === $x2 || $y1 === $y2) {
                $points[] = [$x1, $y1, $x2, $y2];
            }
        }

        return $points;
    }

    /**
     * @return array<array<int>>
     */
    private function listPointsBetweenPoints(int $x1, int $y1, int $x2, int $y2): array
    {
        $points = [];

        if ($x1 === $x2) {
            // vertical line
            $start = min($y1, $y2);
            $end = max($y1, $y2);
            for ($i = $start; $i <= $end; $i++) {
                $points[] = [$x1, $i]; // X remains the same / Y changes
            }

            return $points;
        }

        // horizontal line
        $start = min($x1, $x2);
        $end = max($x1, $x2);
        for ($i = $start; $i <= $end; $i++) {
            $points[] = [$i, $y1]; // X changes / Y remains the same
        }

        return $points;
    }

    /**
     * @param array<string> $input
     */
    public function part1(array $input): int
    {
        $points = $this->parseInput($input);

        // Add the points to the grid

        /** @var array<array<int>> $grid */
        $grid = [];
        foreach ($points as $point) {
            $points_in_between = $this->listPointsBetweenPoints(...$point);

            foreach ($points_in_between as $item) {
                [$x, $y] = $item;
                if (!isset($grid[$x][$y])) {
                    $grid[$x][$y] = 1;
                } else {
                    $grid[$x][$y]++;
                }
            }
        }

        // count the grid points that got covered 2 or more times

        $count = 0;
        foreach ($grid as $row) {
            foreach ($row as $value) {
                if ($value >= 2) {
                    $count++;
                }
            }
        }

        return $count;
    }
}