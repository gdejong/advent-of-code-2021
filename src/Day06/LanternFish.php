<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day06;

class LanternFish
{
    public function calculatePopulation(string $fish_input, int $days): int
    {
        $all_fish = array_map(static function ($fish) {
            return (int)$fish;
        }, explode(",", trim($fish_input)));

        // Sort the fish by their age.
        $fish_by_age = [];
        foreach ($all_fish as $age) {
            if (!isset($fish_by_age[$age])) {
                $fish_by_age[$age] = 1;
            } else {
                $fish_by_age[$age]++;
            }
        }

        for ($i = 0; $i < $days; $i++) {
            // Store fish that will be "reset" at the end
            $fish_with_expired_timer = $fish_by_age[0] ?? 0;
            unset($fish_by_age[0]);

            ksort($fish_by_age);
            foreach ($fish_by_age as $age => $count) {
                // "each other number (but zero) decreases by 1"
                $new_age = $age - 1;
                if (!isset($fish_by_age[$new_age])) {
                    $fish_by_age[$new_age] = $count;
                } else {
                    $fish_by_age[$new_age] += $count;
                }
                unset($fish_by_age[$age]);
            }

            // bring back any fish that has an expired timer
            // "a 0 becomes a 6 and adds a new 8 to the end of the list"
            if ($fish_with_expired_timer > 0) {
                if (!isset($fish_by_age[8])) {
                    $fish_by_age[8] = $fish_with_expired_timer;
                } else {
                    $fish_by_age[8] += $fish_with_expired_timer;
                }
                if (!isset($fish_by_age[6])) {
                    $fish_by_age[6] = $fish_with_expired_timer;
                } else {
                    $fish_by_age[6] += $fish_with_expired_timer;
                }
            }
        }

        return array_sum($fish_by_age);
    }
}
