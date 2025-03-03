<?php

set_time_limit(610);

require_once __DIR__ . '/../vendor/autoload.php';

use Solver\Solver;
use Dotenv\Dotenv;

try {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    $dotenv->required('APIKEY')->notEmpty();
} catch (\Exception $e) {
    echo "Error loading .env file: " . $e->getMessage() . "\n";
    exit(1);
}

$solver = new Solver([
    'apiKey' => $_ENV['APIKEY']
]);

try {
    $results = $solver->friendlycaptchaproxyless([
        'websiteURL' => 'https://axeptio.eu/',
        'websiteKey' => 'FCMNR8PVIO5UHGTM'
    ]);

    echo json_encode($results, JSON_PRETTY_PRINT) . "\n";
} catch (\Exception $e) {
    if ($e instanceof \Solver\Exceptions\SolverException) {
        echo "\033[31m" . $e->getTaskId() . " - " . $e->getErrorCode() . " - " . $e->getErrorDescription() . "\033[0m";
    } else {
        echo "Error: " . $e->getMessage() . "\n";
    }
    exit(1);
}

exit(0);
