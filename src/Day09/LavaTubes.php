<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day09;

class LavaTubes
{
    /**
     * @param array<string> $input
     *
     * @return array<array<int>>
     */
    private function parseInput(array $input): array
    {
        /** @var array<array<int>> $floor */
        $floor = [];

        foreach ($input as $level => $item) {
            $numbers = array_map(static function (string $num) {
                return (int)$num;
            }, str_split($item));

            $floor[$level] = $numbers;
        }

        return $floor;
    }

    /**
     * @param array<array<int>> $floor
     *
     * @return Point[]
     */
    private function findLowPoints(array $floor): array
    {
        // Find all low points.
        $low_points = [];
        /** @var int $y */
        foreach ($floor as $y => $row) {
            /** @var int $x */
            foreach ($row as $x => $number) {
                // find the other (max 4) numbers.
                /** @var non-empty-array<int> $adjacent_locations */
                $adjacent_locations = [];

                foreach ([[0, 1], [0, -1], [-1, 0], [1, 0]] as $directions) {
                    [$add_x, $add_y] = $directions;
                    $new_x = $x + $add_x;
                    $new_y = $y + $add_y;

                    if (isset($floor[$new_y][$new_x])) {
                        $adjacent_locations[] = $floor[$new_y][$new_x];
                    }
                }

                // Find the locations that are lower than any of its adjacent locations
                if ($number < min($adjacent_locations)) {
                    $low_points[] = new Point($x, $y, $number);
                }
            }
        }

        return $low_points;
    }

    /**
     * @param array<string> $input
     */
    public function part1(array $input): int
    {
        $floor = $this->parseInput($input);

        $low_points = $this->findLowPoints($floor);

        // Calculate the risk level
        $risk_level = 0;
        foreach ($low_points as $low_point) {
            $risk_level += $low_point->value + 1;
        }

        return $risk_level;
    }

    /**
     * @param array<array<int>> $floor
     *
     * @return Point[]
     */
    private function recursivelyFindBasin(Point $point, array $floor): array
    {
        /** @var Point[] $basin */
        $basin = [];
        $height = $point->value;

        foreach ([[0, 1], [0, -1], [-1, 0], [1, 0]] as $directions) {
            [$add_x, $add_y] = $directions;
            $new_x = $point->x + $add_x;
            $new_y = $point->y + $add_y;

            // Include the point if:
            // - it exists on the map
            // - its value is higher than the current height
            // - its value is lower than 9
            if (isset($floor[$new_y][$new_x]) && $floor[$new_y][$new_x] > $height && $floor[$new_y][$new_x] < 9) {
                $neighbour_point = new Point($new_x, $new_y, $floor[$new_y][$new_x]);
                $basin[] = $neighbour_point;
                /** @noinspection SlowArrayOperationsInLoopInspection */
                $basin = array_merge($basin, $this->recursivelyFindBasin($neighbour_point, $floor));
            }
        }

        return $basin;
    }

    /**
     * @param array<string> $input
     */
    public function part2(array $input): int
    {
        $floor = $this->parseInput($input);

        $low_points = $this->findLowPoints($floor);

        $basin_sizes = [];
        // From every low point trace the basin back to the top
        foreach ($low_points as $low_point) {
            /** @var Point[] $basin */
            $basin = array_merge([$low_point], $this->recursivelyFindBasin($low_point, $floor));

            // Now remove duplicates
            $unique_basin = [];
            foreach ($basin as $point) {
                if (!isset($unique_basin[$point->y][$point->x])) {
                    $unique_basin[$point->y][$point->x] = 1;
                }
            }

            $size = $this->sizeOfBasin($unique_basin);
            $basin_sizes[] = $size;
        }

        rsort($basin_sizes);

        return $basin_sizes[0] * $basin_sizes[1] * $basin_sizes[2];
    }

    /**
     * @param array<array<int>> $basin
     */
    private function sizeOfBasin(array $basin): int
    {
        $size = 0;
        foreach ($basin as $item) {
            $size += count($item);
        }
        return $size;
    }
}
