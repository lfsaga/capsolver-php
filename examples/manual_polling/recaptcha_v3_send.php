<?php

set_time_limit(610);

require(__DIR__ . '/../../src/autoloader.php');

$solver = new \CapSolver\CapSolver('CAI-XXX...');

try {
    $taskId = $solver->send([
        'type'          => 'ReCaptchaV3Task',     // Pass Type as String
        'websiteKey'    => '6LfA5nobAAAAAMxwekgF_DnCofaDlm-YqHX5v1BI',
        'websiteURL'    => 'https://www.freemans.com/',
        'pageAction'    => 'sign_in',
        'proxy'         => 'proxy.provider.io:23331:user1:password1',
//        'proxyAddress'  => 'proxy.provider.io',
//        'proxyPort'     => 23331,
//        'proxyLogin'    => 'user1',
//        'proxyPassword' => 'password1',
    ]);
    sleep(15);
    $code = $solver->getResult($taskId);
} catch (\Exception $e) {
    die($e->getMessage());
}

print_r($code);
die();