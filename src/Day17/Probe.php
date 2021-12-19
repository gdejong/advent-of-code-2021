<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day17;

use InvalidArgumentException;
use RuntimeException;

class Probe
{
    /**
     * preg_match() returns 1 if the pattern matches the given subject.
     */
    private const PREG_MATCH_PATTERN_MATCHES_SUBJECT = 1;

    private const X = 0;
    private const Y = 1;

    public function part1(string $target_area): int
    {
        // target area: x=20..30, y=-10..-5
        if (preg_match("/x=(-?\d+)..(-?\d+),\s+y=(-?\d+)..(-?\d+)/", $target_area, $matches) !== self::PREG_MATCH_PATTERN_MATCHES_SUBJECT) {
            throw new InvalidArgumentException("could not parse input: " . $target_area);
        }

        $x1 = (int)$matches[1];
        $x2 = (int)$matches[2];
        $y1 = (int)$matches[3];
        $y2 = (int)$matches[4];

        $max_y = 0;

        $search_size = max(abs($x1), abs($x2), abs($y1), abs($y2));

        // No need to try negative X velocities, since the target is to the right of the starting point
        for ($velocity_x = 0; $velocity_x < $search_size; $velocity_x++) {
            for ($velocity_y = -$search_size; $velocity_y < $search_size; $velocity_y++) {
                [$hit, $max_y_this_trajectory] = $this->willHitTarget($velocity_x, $velocity_y, $x1, $x2, $y1, $y2);
                if ($hit) {
                    $max_y = max($max_y, $max_y_this_trajectory);
                }
            }
        }

        return $max_y;
    }

    /**
     * @return array{0: bool, 1: int}
     */
    private function willHitTarget(int $velocity_x, int $velocity_y, int $x1, int $x2, int $y1, int $y2): array
    {
        $pos = [0, 0];

        if ($velocity_x === 0 && $velocity_y === 0) {
            return [false, 0];
        }

        $max_y = 0;
        $safety_count = 0;
        while (true) {
            $safety_count++;
            if ($safety_count > 10000) {
                throw new RuntimeException("detected suspected endless loop");
            }

            // The probe's x position increases by its x velocity.
            $pos[self::X] += $velocity_x;
            // The probe's y position increases by its y velocity.
            $pos[self::Y] += $velocity_y;
            // Due to drag, the probe's x velocity changes by 1 toward the value 0
            if ($velocity_x > 0) {
                $velocity_x--;
            } elseif ($velocity_x < 0) {
                $velocity_x++;
            }
            // Due to gravity, the probe's y velocity decreases by 1.
            $velocity_y--;

            $max_y = max($max_y, $pos[self::Y]);

            if ($pos[self::X] >= $x1 && $pos[self::X] <= $x2 && $pos[self::Y] >= $y1 && $pos[self::Y] <= $y2) {
                return [true, $max_y];
            }

            // Check if we overshot the target in the X axis...
            if ($pos[self::X] > $x2) {
                return [false, 0];
            }
            // ... or in the X axis.
            if ($pos[self::Y] < $y2) {
                return [false, 0];
            }
        }
    }
}
