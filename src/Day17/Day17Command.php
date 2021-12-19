<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day17;

use gdejong\AoC2021\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day17Command extends Command
{
    protected static $defaultName = 'day:17';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day_input = File::convertFileToStringArray(__DIR__ . "/input.txt");

        $probe = new Probe();
        $output->writeln("Part 1: " . $probe->part1($day_input[0])); // 4656

        return 0;
    }
}
