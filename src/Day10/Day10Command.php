<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day10;

use gdejong\AoC2021\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day10Command extends Command
{
    protected static $defaultName = 'day:10';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day_input = File::convertFileToStringArray(__DIR__ . "/input.txt");

        $syntax = new Syntax();

        $output->writeln("Part 1: " . $syntax->part1($day_input));

        return 0;
    }
}
