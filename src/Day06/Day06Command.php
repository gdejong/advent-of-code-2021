<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day06;

use gdejong\AoC2021\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day06Command extends Command
{
    protected static $defaultName = 'day:06';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day_input = File::convertFileToStringArray(__DIR__ . "/input.txt");

        $fish = new LanternFish();

        $output->writeln("Part 1: " . $fish->calculatePopulation($day_input[0], 80)); // 343441

        $output->writeln("Part 2: " . $fish->calculatePopulation($day_input[0], 256)); // 1569108373832

        return 0;
    }
}
