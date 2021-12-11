<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day11;

class Octopus
{
    /**
     * @param array<string> $input
     */
    public function part1(array $input): int
    {
        return $this->solve($input, false);
    }

    /**
     * @param array<string> $input
     */
    public function part2(array $input): int
    {
        return $this->solve($input, true);
    }

    /**
     * @param array<array<int>> $grid
     */
    private function gridContainsOnlyValue(array $grid, int $search): bool
    {
        foreach ($grid as $row) {
            foreach ($row as $value) {
                if ($value !== $search) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param array<string> $input
     */
    public function solve(array $input, bool $part2): int
    {
        // Parse the input
        /** @var array<array<int>> $grid */
        $grid = [];
        foreach ($input as $y => $line) {
            foreach (str_split($line) as $x => $energy) {
                $grid[$y][$x] = (int)$energy;
            }
        }

        $flashes = 0;

        if ($part2) {
            $i = 0;
            while (true) {
                $result = $this->loop($grid, $flashes);
                $flashes = $result["flashes"];
                $grid = $result["grid"];
                $i++;

                if ($this->gridContainsOnlyValue($grid, 0)) {
                    return $i;
                }
            }
        }

        // part 1
        for ($i = 0; $i < 100; $i++) {
            $result = $this->loop($grid, $flashes);
            $flashes = $result["flashes"];
            $grid = $result["grid"];
        }

        return $flashes;
    }

    /**
     * @param array<array<int>> $grid
     * @return array{grid: array<array<int>>, flashes: int}
     */
    private function loop(array $grid, int $flashes): array
    {
        // First, the energy level of each octopus increases by 1.
        foreach ($grid as $y => $row) {
            foreach ($row as $x => $value) {
                $grid[$y][$x] = $value + 1;
            }
        }

        // Then, any octopus with an energy level greater than 9 flashes.
        /** @var array<array<bool>> $flashed */
        $flashed = [];
        /** @var int $y */
        foreach ($grid as $y => $row) {
            /** @var int $x */
            foreach ($row as $x => $value) {
                if ($value > 9 && !isset($flashed[$y][$x])) {
                    $result = $this->increaseAdjacentOctopus($grid, $flashed, $flashes, $x, $y);
                    $grid = $result["grid"];
                    $flashes = $result["flashes"];
                    $flashed = $result["flashed"];
                }
            }
        }

        // Finally, any octopus that flashed during this step has its energy level set to 0,
        foreach ($flashed as $y => $row) {
            foreach ($row as $x => $_) {
                $grid[$y][$x] = 0;
            }
        }

        return ["grid" => $grid, "flashes" => $flashes];
    }

    /**
     * @param array<array<int>> $grid
     * @param array<array<bool>> $flashed
     * @return array{grid: array<array<int>>, flashed: array<array<bool>>, flashes: int}
     */
    private function increaseAdjacentOctopus(array $grid, array $flashed, int $flashes, int $x, int $y): array
    {
        $flashed[$y][$x] = true;
        $flashes++;

        foreach ([[-1, -1], [0, -1], [1, -1], [-1, 0], [1, 0], [-1, 1], [0, 1], [1, 1]] as [$change_x, $change_y]) {
            $new_x = $x + $change_x;
            $new_y = $y + $change_y;

            if (!isset($grid[$new_y][$new_x])) {
                continue;
            }

            $grid[$new_y][$new_x] += 1;
            if ($grid[$new_y][$new_x] > 9 && !isset($flashed[$new_y][$new_x])) {
                $result = $this->increaseAdjacentOctopus($grid, $flashed, $flashes, $new_x, $new_y);
                $grid = $result["grid"];
                $flashes = $result["flashes"];
                $flashed = $result["flashed"];
            }
        }

        return ["grid" => $grid, "flashed" => $flashed, "flashes" => $flashes];
    }
}