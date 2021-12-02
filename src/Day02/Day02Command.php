<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day02;

use gdejong\AoC2021\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day02Command extends Command
{
    protected static $defaultName = 'day:02';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day_input = File::convertFileToStringArray(__DIR__ . "/input.txt");

        $route = [];
        foreach ($day_input as $item) {
            [$route_cmd, $steps] = explode(" ", $item);
            $route[] = [$route_cmd, (int)$steps];
        }

        $submarine = new SubmarinePosition();

        /** @psalm-suppress InvalidScalarArgument */
        $result_part_1 = $submarine->calculatePart1($route);
        $output->writeln("Part 1: " . $result_part_1);

        /** @psalm-suppress InvalidScalarArgument */
        $result_part_2 = $submarine->calculatePart2($route);
        $output->writeln("Part 2: " . $result_part_2);

        return 0;
    }
}
