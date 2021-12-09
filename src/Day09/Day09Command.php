<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day09;

use gdejong\AoC2021\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day09Command extends Command
{
    protected static $defaultName = 'day:09';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day_input = File::convertFileToStringArray(__DIR__ . "/input.txt");

        $lava_tubes = new LavaTubes();

        $output->writeln("Part 1: " . $lava_tubes->part1($day_input));

        return 0;
    }
}
