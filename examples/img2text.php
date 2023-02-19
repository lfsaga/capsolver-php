<?php

set_time_limit(610);

require(__DIR__ . '/../src/autoloader.php');

$solver = new \CapSolver\CapSolver('CAI-XXX...');

try {
    $solution = $solver->img2txt([
        'body'    => '...',
//        'module'    => '...',     // optional
//        'score'    => 0.01,       // optional
//        'case'    => false,       // optional
    ]);
} catch (\Exception $e) {
    die($e);
}

print_r($solution);
die();