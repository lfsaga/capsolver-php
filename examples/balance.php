<?php

set_time_limit(610);

require(__DIR__ . '/../src/autoloader.php');

$solver = new \CapSolver\CapSolver('CAI-XXX...');

try {
    $result = $solver->balance();
} catch (\Exception $e) {
    die($e->getMessage());
}

die('Balance (USD): ' . $result);
