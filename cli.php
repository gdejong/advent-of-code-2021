<?php
declare(strict_types=1);

use gdejong\AoC2021\Day01\Day01Command;
use gdejong\AoC2021\Day02\Day02Command;
use gdejong\AoC2021\Day03\Day03Command;
use gdejong\AoC2021\Day04\Day04Command;
use gdejong\AoC2021\Day05\Day05Command;
use gdejong\AoC2021\Day06\Day06Command;
use gdejong\AoC2021\Day07\Day07Command;
use gdejong\AoC2021\Day08\Day08Command;
use gdejong\AoC2021\Day09\Day09Command;
use Symfony\Component\Console\Application;

require_once __DIR__ . DIRECTORY_SEPARATOR . "vendor/autoload.php";

$application = new Application();

$application->addCommands([
    new Day01Command(),
    new Day02Command(),
    new Day03Command(),
    new Day04Command(),
    new Day05Command(),
    new Day06Command(),
    new Day07Command(),
    new Day08Command(),
    new Day09Command(),
]);

$application->run();
