<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day03;

use gdejong\AoC2021\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day03Command extends Command
{
    protected static $defaultName = 'day:03';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day_input = File::convertFileToStringArray(__DIR__ . "/input.txt");

        $power = new PowerConsumption();

        $output->writeln("Part 1: " . $power->part1($day_input));

        return 0;
    }
}
