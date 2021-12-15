<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day15;

use gdejong\AoC2021\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day15Command extends Command
{
    protected static $defaultName = 'day:15';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day_input = File::convertFileToStringArray(__DIR__ . "/input.txt");

        $cave = new Cave();

        $output->writeln("Part 1: " . $cave->part1($day_input)); // 447

        $output->writeln("Part 2: " . $cave->part2($day_input)); // 2825

        return 0;
    }
}
