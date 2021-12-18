<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day16;

use gdejong\AoC2021\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day16Command extends Command
{
    protected static $defaultName = 'day:16';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day_input = File::convertFileToStringArray(__DIR__ . "/input.txt");

        $decoder = new BitsDecoder();

        $output->writeln("Part 1: " . $decoder->part1($day_input[0])); // 986

        $output->writeln("Part 2: " . $decoder->part2($day_input[0])); // 18234816469452

        return 0;
    }
}
