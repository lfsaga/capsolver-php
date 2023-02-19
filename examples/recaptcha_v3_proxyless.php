<?php

set_time_limit(610);

require(__DIR__ . '/../src/autoloader.php');

$solver = new \CapSolver\CapSolver('CAI-XXX...');

try {
    $solution = $solver->recaptchav3proxyless([
        'websiteKey'    => '6LfA5nobAAAAAMxwekgF_DnCofaDlm-YqHX5v1BI',
        'websiteURL'    => 'https://www.freemans.com/',
        'pageAction'    => 'sign_in',
    ]);
} catch (\Exception $e) {
    die($e->getMessage());
}

print_r($solution);
die();