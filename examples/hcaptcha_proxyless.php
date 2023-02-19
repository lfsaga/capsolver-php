<?php

set_time_limit(610);

require(__DIR__ . '/../src/autoloader.php');

$solver = new \CapSolver\CapSolver('CAI-XXX...');

try {
    $solution = $solver->hcaptchaproxyless([
        'websiteURL'    => 'https://discord.com/',
        'websiteKey'    => '4c672d35-0701-42b2-88c3-78380b0db560',
//        'isInvisible'    => true,                     // optional
//        'enterprisePayload'    => new stdClass(),     // optional
//        'userAgent'    => "...",                      // optional
    ]);
} catch (\Exception $e) {
    die($e);
}

print_r($solution);
die();