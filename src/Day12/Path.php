<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day12;

class Path
{
    /**
     * @param array<array<string>> $vertices
     */
    private function findRoute(string $from, array $vertices, array $route_so_far, array &$found_routes, bool $part2): void
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

            if (!$seen_before || !$is_small) {
                $this->findRoute($neighbour_node, $vertices, $route_so_far, $found_routes, $part2);
            } elseif ($part2 && $neighbour_node !== "end" && $neighbour_node !== "start") {
                $this->findRoute($neighbour_node, $vertices, $route_so_far, $found_routes, false);
            }
        }
    }

    /**
     * @param array<string> $input
     */
    public function part1(array $input): int
    {
        $vertices = $this->parseInput($input);

        $routes = [];

        $this->findRoute("start", $vertices, [], $routes, false);

        return count($routes);
    }

    /**
     * @param array<string> $input
     */
    public function part2(array $input): int
    {
        $vertices = $this->parseInput($input);

        $routes = [];
        $this->findRoute("start", $vertices, [], $routes, true);

        return count($routes);
    }

    /**
     * @param array<string> $input
     * @return array<array<string>>
     */
    private function parseInput(array $input): array
    {
        $vertices = [];

        foreach ($input as $path) {
            [$from, $to] = explode("-", $path);
            $vertices[$to][] = $from;
            $vertices[$from][] = $to;
        }

        return $vertices;
    }
}