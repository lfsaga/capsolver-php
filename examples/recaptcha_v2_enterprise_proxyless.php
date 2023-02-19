<?php

set_time_limit(610);

require(__DIR__ . '/../src/autoloader.php');

$solver = new \CapSolver\CapSolver('CAI-XXX...');

try {
    $solution = $solver->recaptchav2enterpriseproxyless([
        'websiteKey'    => '6Ldbp6saAAAAAAwuhsFeAysZKjR319pRcKUitPUO',
        'websiteURL'    => 'https://login.yahoo.net',
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