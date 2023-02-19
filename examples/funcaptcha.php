<?php

set_time_limit(610);

require(__DIR__ . '/../src/autoloader.php');

$solver = new \CapSolver\CapSolver('CAI-XXX...');

try {
    $solution = $solver->funcaptcha([
        'websiteURL'    => 'https://thecheesecakefactory.cashstar.com/',
        'websitePublicKey'    => '84E1DACC-3B8E-04D6-6E35-2A7D2B8ACFE1',
        'funcaptchaApiJSSubdomain'    => 'client-api.arkoselabs.com',

        'proxy'         => 'proxy.provider.io:23331:user1:password1',
//        'proxyAddress'  => 'proxy.provider.io',
//        'proxyPort'     => 23331,
//        'proxyLogin'    => 'user1',
//        'proxyPassword' => 'password1',
    ]);
} catch (\Exception $e) {
    die($e);
}

print_r($solution);
die();