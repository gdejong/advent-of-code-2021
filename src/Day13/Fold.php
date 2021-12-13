<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day13;

use LogicException;

class Fold
{
    /**
     * @param array<string> $input
     */
    public function part1(array $input): int
    {
        $parsed = $this->parseInput($input);
        $grid = $parsed["grid"];
        $folds = $parsed["folds"];

        $first_fold = reset($folds);
        [$fold_direction, $fold_line] = $first_fold;

        $grid = $this->fold($grid, $fold_direction, $fold_line);

        return $this->countDots($grid);
    }

    /**
     * @param array<string> $input
     */
    public function part2(array $input): void
    {
        $parsed = $this->parseInput($input);
        $grid = $parsed["grid"];
        $folds = $parsed["folds"];

        foreach ($folds as [$fold_direction, $fold_line]) {
            $grid = $this->fold($grid, $fold_direction, $fold_line);
        }

        $this->printGrid($grid);
    }

    /**
     * @param array<string> $input
     *
     * @return array{grid: array<array<bool>>, folds: array<array{0: string, 1: int}>}
     */
    private function parseInput(array $input): array
    {
        $grid = [];
        $folds = [];

        $width = 1;
        $height = 1;
        foreach ($input as $line) {
            if (str_contains($line, ",")) {
                [$x, $y] = explode(",", trim($line));
                $width = max($width, (int)$x);
                $height = max($height, (int)$y);
            }
        }
        // Init grid
        for ($y = 0; $y <= $height; $y++) {
            for ($x = 0; $x <= $width; $x++) {
                $grid[$y][$x] = false;
            }
        }


        foreach ($input as $line) {
            if (trim($line) === "") {
                continue;
            }

            if (str_contains($line, ",")) {
                [$x, $y] = explode(",", trim($line));
                $grid[$y][$x] = true;
                continue;
            }

            // fold instruction
            preg_match("/fold along ([a-z])=(\d+)/", $line, $match);
            $folds[] = [$match[1], (int)$match[2]];
        }

        return ["grid" => $grid, "folds" => $folds];
    }

    /**
     * @param array<array<bool>> $grid
     *
     * @return array<array<bool>>
     */
    private function fold(array $grid, string $fold_direction, int $fold_line): array
    {
        $result = $this->gridSize($grid);
        $height = $result["height"];
        $width = $result["width"];

        if ($fold_direction === "y") {
            $grid = $this->foldUp($grid, $height, $width, $fold_line);
        } else {
            $grid = $this->foldLeft($grid, $height, $width, $fold_line);
        }

        return $grid;
    }

    /**
     * @param array<array<bool>> $grid
     *
     * @return array<array<bool>>
     */
    private function foldUp(array $grid, int $height, int $width, int $fold_line): array
    {
        $folded_grid = [];

        $i_from_zero = 0;
        for ($i_from_end = $height; $i_from_end > $fold_line; $i_from_end--, $i_from_zero++) {
            // Get the lines to merge
            $first_line = $grid[$i_from_zero];
            $last_line = $grid[$i_from_end];
            if (count($first_line) !== count($last_line)) {
                throw new LogicException("count mismatch");
            }

            // Merge the lines
            $new_line = [];
            for ($i = 0; $i <= $width; $i++) {
                $new_line[$i] = $first_line[$i] || $last_line[$i];
            }
            $folded_grid[] = $new_line;
        }

        return $folded_grid;
    }

    /**
     * @param array<array<bool>> $grid
     *
     * @return array<array<bool>>
     */
    private function foldLeft(array $grid, int $height, int $width, int $fold_line): array
    {
        $folded_grid = [];

        for ($i = 0; $i <= $height; $i++) {
            // merge both halves
            $new_line = [];
            for ($j = 0; $j < $fold_line; $j++) {
                $new_line[$j] = $grid[$i][$j] || $grid[$i][$width - $j];
            }
            $folded_grid[] = $new_line;
        }

        return $folded_grid;
    }

    /**
     * @param array<array<bool>> $grid
     */
    private function countDots(array $grid): int
    {
        $dots = 0;

        foreach ($grid as $row) {
            foreach ($row as $value) {
                if ($value === true) {
                    $dots++;
                }
            }
        }

        return $dots;
    }

    /**
     * @param array<array<bool>> $grid
     *
     * @return array{width: int, height: int}
     */
    private function gridSize(array $grid): array
    {
        /** @psalm-suppress ArgumentTypeCoercion */
        $height = max(array_keys($grid));
        $width = -1;
        foreach ($grid as $y) {
            /** @noinspection PhpNestedMinMaxCallInspection Not true! */
            /** @psalm-suppress ArgumentTypeCoercion */
            $width = max($width, max(array_keys($y)));
        }

        return ["width" => (int)$width, "height" => (int)$height];
    }

    /**
     * @param array<array<bool>> $grid
     */
    private function printGrid(array $grid): void
    {
        $result = $this->gridSize($grid);
        $height = $result["height"];
        $width = $result["width"];

        for ($y = 0; $y <= $height; $y++) {
            for ($x = 0; $x <= $width; $x++) {
                if (isset($grid[$y][$x]) && $grid[$y][$x] === true) {
                    echo "#";
                } else {
                    echo ".";
                }
            }
            echo PHP_EOL;
        }
    }
}
