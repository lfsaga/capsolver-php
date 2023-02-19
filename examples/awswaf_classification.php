<?php

set_time_limit(610);

require(__DIR__ . '/../src/autoloader.php');

$solver = new \CapSolver\CapSolver('CAI-XXX...');

try {
    $solution = $solver->awswafclassification([
        'images'    => array('base64:...', 'base64:...', '...'),
        'question'    => '...?',    // https://docs.capsolver.com/guide/recognition/AwsWafClassification.html
    ]);
} catch (\Exception $e) {
    die($e);
}

print_r($solution);
die();