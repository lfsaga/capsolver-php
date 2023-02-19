<?php

set_time_limit(610);

require(__DIR__ . '/../src/autoloader.php');

$solver = new \CapSolver\CapSolver('CAI-XXX...');

try {
    $solution = $solver->geetest([
        'websiteURL'    => 'https://us.shein.com/user/auth/login?direction=nav',
//        'gt'    => '032a4d124dd9598cb268400caaa2394a',
//        'challenge'    => 'cddf9ffb3569d0bc8677075cafb68053',
        'captchaId'    => 'us.shein.com/geetest',                   // required only for geetest v4
        'geetestApiServerSubdomain'    => 'us.shein.com/geetest',   // optional

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