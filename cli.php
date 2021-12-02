<?php
declare(strict_types=1);

use gdejong\AoC2021\Day01\Day01Command;
use gdejong\AoC2021\Day02\Day02Command;
use Symfony\Component\Console\Application;

require_once __DIR__ . DIRECTORY_SEPARATOR . "vendor/autoload.php";

$application = new Application();

$application->addCommands([
    new Day01Command(),
    new Day02Command(),
]);

$application->run();
