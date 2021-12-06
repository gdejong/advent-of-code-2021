<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day06;

class LanternFish
{
    public function part1(string $fish_input, int $days = 80): int
    {
        $all_fish = array_map(static function ($fish) {
            return (int)$fish;
        }, explode(",", trim($fish_input)));

        for ($i = 0; $i < $days; $i++) {
            foreach ($all_fish as $fish_index => $fish) {
                if ($fish === 0) {
                    $all_fish[$fish_index] = 6;
                    $all_fish[] = 8;
                } else {
                    $all_fish[$fish_index] = $fish - 1;
                }
            }
        }

        return count($all_fish);
    }
}
