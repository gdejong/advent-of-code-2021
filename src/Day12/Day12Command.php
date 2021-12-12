<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day12;

use gdejong\AoC2021\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day12Command extends Command
{
    protected static $defaultName = 'day:12';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day_input = File::convertFileToStringArray(__DIR__ . "/input.txt");

        $path = new Path();

        $output->writeln("Part 1: " . $path->part1($day_input)); // 4970

        $output->writeln("Part 2: " . $path->part2($day_input)); // 137948

        return 0;
    }
}
