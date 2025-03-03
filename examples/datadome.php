<?php

set_time_limit(610);

require_once __DIR__ . '/../vendor/autoload.php';

use Solver\Solver;
use Dotenv\Dotenv;

try {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    $dotenv->required(['APIKEY', 'PROXYSTRING'])->notEmpty();
} catch (\Exception $e) {
    echo "Error loading .env file: " . $e->getMessage() . "\n";
    exit(1);
}

$solver = new Solver([
    'apiKey' => $_ENV['APIKEY']
]);

try {
    $results = $solver->datadome([
        'websiteURL' => 'https://allegro.pl/',
        'userAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
        'captchaUrl' => 'https://geo.captcha-delivery.com/captcha/?initialCid=DAVfsaHuc~1lJNTKFkZF4ix4sFDHffsYNtWio9i_1Sv9MkZ~JXR5RxmuxI76~WhiQFAs39wLpbvE8~uze6FC91XEaCCvadHZPmAUp71wrKSCShmyABxSEvLoEzSAnd66&cid=DAVfsaHuc~1lJNTKFkZF4ix4sFDHffsYNtWio9i_1Sv9MkZ~JXR5RxmuxI76~WhiQFAs39wLpbvE8~uze6FC91XEaCCvadHZPmAUp71wrKSCShmyABxSEvLoEzSAnd66&referer=https%3A%2F%2Fallegro.pl%2F&hash=77DC0FFBAA0B77570F6B414F8E5BDB&t=fe&s=29701&e=9e3ce65fd6c57373d8ff7cb729a4e78a8ed3f43d0174456e125ba4816b40b060&ir=414&dm=dc_ir',
        'proxy' => $_ENV['PROXYSTRING']
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
