<?php

set_time_limit(610);

require(__DIR__ . '/../src/autoloader.php');

$solver = new \CapSolver\CapSolver('CAI-XXX...');

try {
    $solution = $solver->recaptchav2([
        'websiteKey'    => '6Le-wvkSAAAAAPBMRTvw0Q4Muexq9bi0DJwx_mJ-',
        'websiteURL'    => 'https://www.google.com/recaptcha/api2/demo',
//        'isInvisible' =>  true,                                                 // optional
//        'enterprisePayload' =>  new stdClass(),                                 // optional
//        'apiDomain' =>  "...",                                                  // optional
//        'userAgent' =>  "...",                                                  // optional
//        'cookies' =>  new Array(),                                              // optional

        'proxy'         => 'proxy.provider.io:23331:user1:password1',
//        'proxyAddress'  => 'proxy.provider.io',
//        'proxyPort'     => 23331,
//        'proxyLogin'    => 'user1',
//        'proxyPassword' => 'password1',
    ]);
} catch (\Exception $e) {
    die($e->getMessage());
}

print_r($solution);
die();