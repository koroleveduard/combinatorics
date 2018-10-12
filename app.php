<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use App\Command\PermutationCommand;

$application = new Application();

$application->add($command = new PermutationCommand());
$application->setDefaultCommand($command->getName());

$application->run();
