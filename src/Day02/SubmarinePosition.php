<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day02;

use LogicException;

class SubmarinePosition
{
    /**
     * @param array<array<string, int>> $route
     */
    public function calculatePart1(array $route): int
    {
        $horizontal_position = 0;
        $depth = 0;

        foreach ($route as $item) {
            [$route_cmd, $steps] = $item;

            switch ($route_cmd) {
                case "forward":
                    $horizontal_position += $steps;
                    break;
                case "down":
                    $depth += $steps;
                    break;
                case "up":
                    $depth -= $steps;
                    break;
                default:
                    throw new LogicException("Invalid movement: " . $route_cmd);
            }
        }


        return $horizontal_position * $depth;
    }
}
