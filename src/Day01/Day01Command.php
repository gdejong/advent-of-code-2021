<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day01;

use gdejong\AoC2021\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day01Command extends Command
{
    protected static $defaultName = 'day:01';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day_input = File::convertFileToIntArray(__DIR__ . "/input.txt");

        $sonar_sweep = new SonarSweep();

        $result_part_1 = $sonar_sweep->countIncreasingDepths($day_input);
        $output->writeln("Part 1: " . $result_part_1);

        $result_part_2 = $sonar_sweep->countIncreasingDepthsUsingSlidingWindow($day_input);
        $output->writeln("Part 2: " . $result_part_2);

        return 0;
    }
}
