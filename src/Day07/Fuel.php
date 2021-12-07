<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day07;

class Fuel
{
    public function part1(string $input): int
    {
        $numbers = array_map(static function ($fish) {
            return (int)$fish;
        }, explode(",", trim($input)));


        $unique = array_unique($numbers);

        $fuel_by_position = [];

        foreach ($unique as $horizontal_position) {
            $fuel = 0;
            foreach ($numbers as $number) {
                $fuel += abs($number - $horizontal_position);
            }
            $fuel_by_position[$horizontal_position] = $fuel;
        }

        return min($fuel_by_position);
    }
}
