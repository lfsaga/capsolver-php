<?php

set_time_limit(610);

require(__DIR__ . '/../src/autoloader.php');

$solver = new \CapSolver\CapSolver('CAI-XXX...');

try {
    $solution = $solver->funcaptchaclassification([
        'images'    => 'base64:...',    // screenshot
        'question'    => '...?',        // Question name. this param value from API response game_variant field. Exmaple: maze,maze2,flockCompass,3d_rollball_animals
    ]);
} catch (\Exception $e) {
    die($e);
}

print_r($solution);
die();