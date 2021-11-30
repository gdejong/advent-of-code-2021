<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day01;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day01Command extends Command
{
    protected static $defaultName = 'day:01';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("Here we go!");

        return 0;
    }
}
