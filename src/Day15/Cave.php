<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day15;

class Cave
{

    /**
     * @param array<string> $input
     */
    public function part1(array $input): int
    {
        /** @var array<array<int>> $grid */
        $grid = [];
        foreach ($input as $line) {
            $grid[] = array_map(static function (string $number) {
                return (int)$number;
            }, str_split($line));
        }

        // Dijkstra to the rescue

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
        $distance_to_nodes = [];
        $found_routes = [];
        // At this point all distances are unknown
        foreach (array_keys($graph) as $val) {
            $found_routes[$val] = PHP_INT_MAX;
        }
        $found_routes[$start] = 0; // It takes no effort to reach the start, we are already at start!

        while (!empty($found_routes)) {
            /** @var string $min */
            $min = array_search(min($found_routes), $found_routes, true);

            foreach ($graph[$min] as $key => $val) {
                if (!empty($found_routes[$key]) && $found_routes[$min] + $val < $found_routes[$key]) {
                    $found_routes[$key] = $found_routes[$min] + $val;
                    $distance_to_nodes[$key] = $found_routes[$key];
                }
            }
            unset($found_routes[$min]);
        }

        return $distance_to_nodes[$end];
    }
}
