<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day03;

use LogicException;

class PowerConsumption
{
    private const OXYGEN_RATING = 0;
    private const CO2_RATING = 1;

    /**
     * @param array<array-key, numeric-string> $input
     */
    public function part1(array $input): int
    {
        /** @var array<array-key, array<array-key, int>> $bit_positions */
        $bit_positions = [];

        foreach ($input as $binary_number) {
            foreach (str_split($binary_number) as $pos => $bit) {
                $bit = (int)$bit;
                if (!isset($bit_positions[$pos][$bit])) {
                    $bit_positions[$pos][$bit] = 1;
                } else {
                    $bit_positions[$pos][$bit]++;
                }
            }
        }

        $gamma_rate = "";
        $epsilon_rate = "";

        foreach ($bit_positions as $bit_position) {
            [$nr_of_zeros, $nr_of_ones] = $bit_position;
            if ($nr_of_ones === $nr_of_zeros) {
                throw new LogicException("Did not expect the number of zeros and ones to be equal");
            }

            if ($nr_of_ones > $nr_of_zeros) {
                $gamma_rate .= "1";
                $epsilon_rate .= "0";
            } else {
                $gamma_rate .= "0";
                $epsilon_rate .= "1";
            }
        }

        $gamma_rate = (int)bindec($gamma_rate);
        $epsilon_rate = (int)bindec($epsilon_rate);

        return $gamma_rate * $epsilon_rate;
    }

    /**
     * @param array<array-key, numeric-string> $input
     */
    public function part2(array $input): int
    {
        $oxygen = $this->calculateRating($input, self::OXYGEN_RATING);
        $co2 = $this->calculateRating($input, self::CO2_RATING);

        return $oxygen * $co2;
    }

    /**
     * @param array<array-key, numeric-string> $input
     */
    private function calculateRating(array $input, int $type): int
    {
        $bit_position = 0;
        while (count($input) > 1) {
            $keep = $this->findBitToKeep($input, $bit_position, $type);

            $input = $this->filterValue($input, $bit_position, $keep);

            $bit_position++;
        }

        $value = reset($input);

        return (int)bindec($value);
    }

    /**
     * @param array<array-key, numeric-string> $input
     *
     * @return array<array-key, numeric-string>
     */
    private function filterValue(array $input, int $bit_position, int $keep): array
    {
        foreach ($input as $i => $binary_number) {
            $value = (int)$binary_number[$bit_position];
            if ($value !== $keep) {
                unset($input[$i]);
            }
        }

        return $input;
    }

    /**
     * @param array<array-key, numeric-string> $input
     *
     * @return int 0 or 1
     */
    private function findBitToKeep(array $input, int $bit_position, int $type): int
    {
        $zeros = 0;
        $ones = 0;
        foreach ($input as $binary_number) {
            $value = (int)$binary_number[$bit_position];
            if ($value === 0) {
                $zeros++;
            } else {
                $ones++;
            }
        }

        if ($type === self::OXYGEN_RATING) {
            if ($zeros === $ones || $ones > $zeros) {
                return 1;
            }

            return 0;
        }

        // else
        if ($zeros === $ones || $ones > $zeros) {
            return 0;
        }

        return 1;
    }
}
