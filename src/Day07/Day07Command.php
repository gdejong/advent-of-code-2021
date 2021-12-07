<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day07;

use gdejong\AoC2021\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day07Command extends Command
{
    protected static $defaultName = 'day:07';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day_input = File::convertFileToStringArray(__DIR__ . "/input.txt");

        $fuel = new Fuel();

        $output->writeln("Part 1: " . $fuel->part1($day_input[0])); //

        return 0;
    }
}
