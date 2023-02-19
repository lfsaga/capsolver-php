<?php

set_time_limit(610);

require(__DIR__ . '/../src/autoloader.php');

$solver = new \CapSolver\CapSolver('CAI-XXX...');

try {
    $solution = $solver->hcaptcha([
        'websiteURL'    => 'https://discord.com/',
        'websiteKey'    => '4c672d35-0701-42b2-88c3-78380b0db560',
//        'isInvisible'    => true,                     // optional
//        'enterprisePayload'    => new stdClass(),     // optional
//        'userAgent'    => "...",                      // optional

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