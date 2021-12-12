<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day12;

class Path
{
    /**
     * @param array<array<string>> $vertices
     */
    private function findRoute(string $from, array $vertices, array $route_so_far, array &$found_routes): void
    {
        $route_so_far[] = $from;

        // reached the end?
        if ($from === "end") {
            $found_routes[] = $route_so_far;
            return;
        }

        foreach ($vertices[$from] as $neighbour_node) {
            $is_small = $neighbour_node === strtolower($neighbour_node);
            $seen_before = in_array($neighbour_node, $route_so_far);
            // small caves may not be seen more than once
            if (!$seen_before || !$is_small) {
                $this->findRoute($neighbour_node, $vertices, $route_so_far, $found_routes);
            }
        }
    }

    /**
     * @param array<string> $input
     */
    public function part1(array $input): int
    {
        $vertices = [];

        foreach ($input as $path) {
            [$from, $to] = explode("-", $path);
            $vertices[$to][] = $from;
            $vertices[$from][] = $to;
        }

        $routes = [];

        $this->findRoute("start", $vertices, [], $routes);

        return count($routes);
    }
}