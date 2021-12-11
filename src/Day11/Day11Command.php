<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day11;

use gdejong\AoC2021\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day11Command extends Command
{
    protected static $defaultName = 'day:11';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day_input = File::convertFileToStringArray(__DIR__ . "/input.txt");

        $octopus = new Octopus();

        $output->writeln("Part 1: " . $octopus->part1($day_input)); // 1721

        $output->writeln("Part 2: " . $octopus->part2($day_input)); // 298

        return 0;
    }
}
