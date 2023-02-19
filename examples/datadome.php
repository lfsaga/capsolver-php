<?php

set_time_limit(610);

require(__DIR__ . '/../src/autoloader.php');

$solver = new \CapSolver\CapSolver('CAI-XXX...');

try {
    $solution = $solver->datadome([
        'websiteURL'    => 'https://www.pokemoncenter.com/',
        'userAgent'    => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36',
        'captchaUrl'    => 'https://geo.captcha-delivery.com/captcha/?initialCid=AHrlqAAAAAMAlk-FmAyNOW8AUyTH_g%3D%3D&hash=5B45875B653A484CC79E57036CE9FC&cid=noJuZstmvINksqOxaXWQogbPBd01y3VaH3r-CZ4eqK4roZuelJMHVhO2rR0IySRieoAivkg74B4UpJ.xj.jVNB6-aLaW.Bwvik7__EncryD6COavwx8RmOqgZ7DK_3v&t=fe&referer=https%3A%2F%2Fwww.pokemoncenter.com%2F&s=9817&e=2b1d5a78107ded0dcdc8317aa879979ed5083a2b3a95b734dbe7871679e14032',
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