<?php

set_time_limit(610);

require(__DIR__ . '/../src/autoloader.php');

$solver = new \CapSolver\CapSolver('CAI-XXX...');

try {
    $solution = $solver->geetestproxyless([
        'websiteURL'    => 'https://us.shein.com/user/auth/login?direction=nav',
//        'gt'    => '032a4d124dd9598cb268400caaa2394a',
//        'challenge'    => 'cddf9ffb3569d0bc8677075cafb68053',
        'captchaId'    => 'us.shein.com/geetest',                   // required only for geetest v4
        'geetestApiServerSubdomain'    => 'us.shein.com/geetest',   // optional
    ]);
} catch (\Exception $e) {
    die($e);
}

print_r($solution);
die();