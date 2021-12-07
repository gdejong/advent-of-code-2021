<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day07;

class Fuel
{
    /**
     * @return non-empty-array<int>
     */
    private function parseInput(string $input): array
    {
        return array_map(static function ($fish) {
            return (int)$fish;
        }, explode(",", trim($input)));
    }

    public function part1(string $input): int
    {
        $numbers = $this->parseInput($input);

        $unique = array_unique($numbers);

        /** @var non-empty-array<int, int> $fuel_by_position */
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

    public function part2(string $input): int
    {
        $numbers = $this->parseInput($input);

        /** @var non-empty-array<int, int> $fuel_by_position */
        $fuel_by_position = [];

        $min = min($numbers);
        $max = max($numbers);

        foreach (range($min, $max) as $horizontal_position) {
            $fuel = 0;

            foreach ($numbers as $number) {
                $start = min($number, $horizontal_position);
                $end = max($number, $horizontal_position);

                if ($start === $end) {
                    continue;
                }

                $fuel += $this->sumFuelPart2($end - $start);
            }

            $fuel_by_position[$horizontal_position] = $fuel;
        }

        return min($fuel_by_position);
    }

    /**
     * A factorial but instead of multiplying we do addition.
     */
    private function sumFuelPart2(int $n): int
    {
        $total = 0;
        for ($i = $n; $i >= 1; $i--) {
            $total += $i;
        }

        return $total;
    }
}
