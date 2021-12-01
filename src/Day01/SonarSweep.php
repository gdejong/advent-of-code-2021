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
}
