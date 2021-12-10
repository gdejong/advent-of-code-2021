<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day08;

use LogicException;

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

    /**
     * @param array<string> $input
     */
    public function part2(array $input): int
    {
        $sum = 0;

        foreach ($input as $line) {
            [$unique_signal_patterns, $output_values] = explode("|", $line);

            /** @var array<string> $output_values_as_array */
            $output_values_as_array = preg_split('/\s+/', trim($output_values));

            /** @var array<string> $unique_signal_patterns_as_array */
            $unique_signal_patterns_as_array = preg_split('/\s+/', trim($unique_signal_patterns));

            foreach ($unique_signal_patterns_as_array as $unique_signal_pattern) {
                echo $this->convert($unique_signal_pattern) . " ";
            }
        }

        return $sum;
    }

    private function convert(string $in): string
    {
        $number_of_segments = strlen($in);

        if ($number_of_segments === 2) {
            return "1";
        }
        if ($number_of_segments === 3) {
            return "7";
        }
        if ($number_of_segments === 4) {
            return "4";
        }
        if ($number_of_segments === 7) {
            return "8";
        }

        // These are more tricky
        if ($number_of_segments === 6) {
            return "0|6|9";
        }
        if ($number_of_segments === 5) {
            return "2|3|5";
        }

        throw new LogicException("should not get here");
    }
}
