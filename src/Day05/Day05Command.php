<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day05;

use gdejong\AoC2021\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day05Command extends Command
{
    protected static $defaultName = 'day:05';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day_input = File::convertFileToStringArray(__DIR__ . "/input.txt");

        $grid = new Grid();

        $output->writeln("Part 1: " . $grid->part1($day_input)); // 6564

        $output->writeln("Part 2: " . $grid->part2($day_input)); // 19172

        return 0;
    }
}
