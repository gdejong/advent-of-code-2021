<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day14;

use gdejong\AoC2021\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day14Command extends Command
{
    protected static $defaultName = 'day:14';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day_input = File::convertFileToStringArray(__DIR__ . "/input.txt");

        $polymer = new Polymer();

        $output->writeln("Part 1: " . $polymer->part1($day_input)); // 2321

        $output->writeln("Part 2: " . $polymer->part2($day_input)); // 2399822193707

        return 0;
    }
}
