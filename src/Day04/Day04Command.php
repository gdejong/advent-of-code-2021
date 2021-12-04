<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day04;

use gdejong\AoC2021\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day04Command extends Command
{
    protected static $defaultName = 'day:04';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var array<array-key, string> $day_input */
        $day_input = File::convertFileToStringArray(__DIR__ . "/input.txt");

        $bingo = new Bingo();

        $output->writeln("Part 1: " . $bingo->part1($day_input));

        return 0;
    }
}
