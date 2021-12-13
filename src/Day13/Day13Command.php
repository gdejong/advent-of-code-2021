<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day13;

use gdejong\AoC2021\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day13Command extends Command
{
    protected static $defaultName = 'day:13';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day_input = File::convertFileToStringArray(__DIR__ . "/input.txt");

        $fold = new Fold();

        $output->writeln("Part 1: " . $fold->part1($day_input)); // 647

        $output->writeln("Part 2:");
        $fold->part2($day_input); // HEJHJRCJ

        return 0;
    }
}
