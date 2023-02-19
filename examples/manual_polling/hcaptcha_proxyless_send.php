<?php

set_time_limit(610);

require(__DIR__ . '/../../src/autoloader.php');

$solver = new \CapSolver\CapSolver('CAI-XXX...');

try {
    $taskId = $solver->send([
        'type'          => 'HCaptchaTaskProxyless',     // Pass Type as String
        'websiteURL'    => 'https://discord.com/',
        'websiteKey'    => '4c672d35-0701-42b2-88c3-78380b0db560',
//        'isInvisible'    => true,                     // optional
//        'enterprisePayload'    => new stdClass(),     // optional
//        'userAgent'    => "...",                      // optional
    ]);
    sleep(15);
    $code = $solver->getResult($taskId);
} catch (\Exception $e) {
    die($e);
}

print_r($code);
die();