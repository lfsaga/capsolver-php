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
    $results = $solver->recaptchav3enterpriseproxyless([
        'websiteURL' => 'https://2captcha.com/demo/recaptcha-v3-enterprise',
        'websiteKey' => '6Lel38UnAAAAAMRwKj9qLH2Ws4Tf2uTDQCyfgR6b',
        'pageAction' => 'demo_action'
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
