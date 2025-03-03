<?php

set_time_limit(610);

require_once __DIR__ . '/../vendor/autoload.php';

use Solver\Solver;
use Dotenv\Dotenv;
use GuzzleHttp\Client;

try {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    $dotenv->required('APIKEY')->notEmpty();
} catch (\Exception $e) {
    echo "Error loading .env file: " . $e->getMessage() . "\n";
    exit(1);
}

$client = new Client();

try {
    $response = $client->get('https://segmentfault.com/gateway/geetest/token');
    $data = json_decode($response->getBody(), true);

    if (!isset($data['gt']) || !isset($data['challenge'])) {
        throw new \Exception("Invalid response structure from API.");
    }
} catch (\Exception $e) {
    echo "Error fetching Geetest token: " . $e->getMessage() . "\n";
    exit(1);
}

$solver = new Solver([
    'apiKey' => $_ENV['APIKEY']
]);

try {
    $results = $solver->geetestproxyless([
        'websiteURL' => 'https://segmentfault.com/',
        'gt' => $data['gt'],
        'challenge' => $data['challenge']
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
