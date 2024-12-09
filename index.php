<?php

require __DIR__ . '/vendor/autoload.php';

use Raven\AocPhp\CommandKernel;

$c = new CommandKernel();
$c->run();

exit;