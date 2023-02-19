<?php

set_time_limit(610);

require(__DIR__ . '/../src/autoloader.php');

$solver = new \CapSolver\CapSolver('CAI-XXX...');

try {
    $solution = $solver->recaptchav2proxyless([
        'websiteKey'    => '6Le-wvkSAAAAAPBMRTvw0Q4Muexq9bi0DJwx_mJ-',
        'websiteURL'    => 'https://www.google.com/recaptcha/api2/demo',
//        'isInvisible' =>  true,                                                 // optional
//        'enterprisePayload' =>  new stdClass(),                                 // optional
//        'apiDomain' =>  "...",                                                  // optional
//        'userAgent' =>  "...",                                                  // optional
//        'cookies' =>  new Array(),                                              // optional
    ]);
} catch (\Exception $e) {
    die($e->getMessage());
}

print_r($solution);
die();