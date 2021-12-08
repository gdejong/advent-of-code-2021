<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day08;

class SevenSegmentDisplay
{
    /**
     * @param array<string> $input
     */
    public function part1(array $input): int
    {
        $count = 0;
        foreach ($input as $line) {
            [$_, $output_values] = explode("|", $line);

            /** @var array<string> $output_values_as_array */
            $output_values_as_array = preg_split('/\s+/', trim($output_values));
            foreach ($output_values_as_array as $output_value) {
                $len = strlen($output_value);
                if ($len === 2 || $len === 3 || $len === 4 || $len === 7) {
                    $count++;
                }
            }
        }

        return $count;
    }
}
