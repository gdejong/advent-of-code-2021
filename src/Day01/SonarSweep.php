<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day01;

class SonarSweep
{
    /**
     * @param array<array-key, int> $input
     */
    public function countIncreasingDepths(array $input): int
    {
        $increasing = 0;
        $previous = null;

        foreach ($input as $depth) {
            if ($previous !== null && $depth > $previous) {
                $increasing++;
            }

            $previous = $depth;
        }

        return $increasing;
    }

    /**
     * @param array<array-key, int> $input
     */
    public function countIncreasingDepthsUsingSlidingWindow(array $input): int
    {
        $increasing = 0;

        $sliding_window_start_1 = 0;
        $sliding_window_start_2 = 1;

        while (true) {
            if (!isset($input[$sliding_window_start_2 + 2])) {
                break;
            }

            $sliding_window_1 = $input[$sliding_window_start_1] + $input[$sliding_window_start_1 + 1] + $input[$sliding_window_start_1 + 2];
            $sliding_window_2 = $input[$sliding_window_start_2] + $input[$sliding_window_start_2 + 1] + $input[$sliding_window_start_2 + 2];

            if ($sliding_window_2 > $sliding_window_1) {
                $increasing++;
            }

            $sliding_window_start_1++;
            $sliding_window_start_2++;
        }

        return $increasing;
    }
}
