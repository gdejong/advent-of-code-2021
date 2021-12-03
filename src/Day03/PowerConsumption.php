<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day03;

use LogicException;

class PowerConsumption
{
    /**
     * @param array<array-key, string> $input
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
}
