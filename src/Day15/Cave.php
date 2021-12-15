<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day15;

class Cave
{
    /**
     * @param array<string> $input
     *
     * @return array<array<int>>
     */
    private function parseInput(array $input): array
    {
        $grid = [];
        foreach ($input as $line) {
            $grid[] = array_map(static function (string $number) {
                return (int)$number;
            }, str_split($line));
        }

        return $grid;
    }

    /**
     * @param array<string> $input
     */
    public function part1(array $input): int
    {
        $grid = $this->parseInput($input);

        return $this->solve($grid);
    }

    /**
     * @param array<int> $row
     *
     * @return array<int>
     */
    private function incrementNumbers(array $row): array
    {
        return array_map(static function (int $number) {
            $new_number = $number + 1;
            if ($new_number > 9) {
                $new_number = 1;
            }
            return $new_number;
        }, $row);
    }

    /**
     * @param array<string> $input
     */
    public function part2(array $input): int
    {
        ini_set('memory_limit', '256M');

        $grid = $this->parseInput($input);

        $expanded_grid = $this->expandGrid($grid);

        return $this->solve($expanded_grid);
    }

    /**
     * @param array<array<int>> $grid
     * @return array<array<int>>
     */
    private function expandGrid(array $grid): array
    {
        $height = count($grid);

        /**
         * Expand horizontally
         *
         * 123      123456789
         * 456  ->  456789123
         * 789      789123456
         */
        foreach ($grid as $y => $row) {
            $add_horizontally = [];
            for ($i = 0; $i < 4; $i++) {
                $row = $this->incrementNumbers($row);
                foreach ($row as $item) {
                    $add_horizontally[] = $item;
                }
            }
            foreach ($add_horizontally as $item) {
                $grid[$y][] = $item;
            }
        }

        // Expand vertically
        for ($i = 0; $i < 4; $i++) {
            $last = array_slice($grid, -$height);
            foreach ($last as $row) {
                $row = $this->incrementNumbers($row);
                $grid[] = $row;
            }
        }

        return $grid;
    }

    /**
     * @param array<array<int>> $grid
     */
    private function solve(array $grid): int
    {
        /** @var array<string, array<string, int>> $graph This graph contains the weights between each connection */
        $graph = [];
        /** @var int $y */
        foreach ($grid as $y => $row) {
            /** @var int $x */
            foreach ($row as $x => $_) {
                // Look around (down, up, left, right) and note the distance to that node from this node
                foreach ([[0, 1], [0, -1], [-1, 0], [1, 0]] as [$add_x, $add_y]) {
                    // Skip non-existing nodes (around the edges of the grid)
                    if (!isset($grid[$y + $add_y][$x + $add_x])) {
                        continue;
                    }
                    $from = $x . "," . $y;
                    $to = ($x + $add_x) . "," . ($y + $add_y);
                    $graph[$from][$to] = $grid[$y + $add_y][$x + $add_x];
                }
            }
        }

        $end = (count(reset($grid)) - 1) . "," . (count($grid) - 1);

        return $this->dijkstra($graph, "0,0", $end);
    }

    /**
     * Might have used a Dijkstra implementation from https://github.com/zairwolf/Algorithms/blob/master/dijkstra_algorithm.php here
     *
     * @param array<string, array<string, int>> $graph
     */
    private function dijkstra(array $graph, string $start, string $end): int
    {
        $nodes_to_check = [];
        // At this point all distances are unknown
        foreach (array_keys($graph) as $val) {
            $nodes_to_check[$val] = PHP_INT_MAX;
        }
        $nodes_to_check[$start] = 0; // It takes no effort to reach the start, we are already at start!

        $distance_to_nodes = [];
        while (!empty($nodes_to_check)) {
            /** @var string $min */
            $min = array_search(min($nodes_to_check), $nodes_to_check, true);
            foreach ($graph[$min] as $key => $val) {
                if (!empty($nodes_to_check[$key]) && $nodes_to_check[$min] + $val < $nodes_to_check[$key]) {
                    $nodes_to_check[$key] = $nodes_to_check[$min] + $val;
                    $distance_to_nodes[$key] = $nodes_to_check[$key];
                }
            }
            unset($nodes_to_check[$min]);
        }

        return $distance_to_nodes[$end];
    }
}
