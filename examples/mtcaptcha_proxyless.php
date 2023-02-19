<?php

set_time_limit(610);

require(__DIR__ . '/../src/autoloader.php');

$solver = new \CapSolver\CapSolver('CAI-XXX...');

try {
    $solution = $solver->mtcaptchaproxyless([
        'websiteURL'    => 'https://www.mtcaptcha.com/',
        'websiteKey'    => 'MTPublic-tqNCRE0GS',
    ]);
} catch (\Exception $e) {
    die($e);
}

print_r($solution);
die();