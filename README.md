# capsolver-php

manage to solve captcha challenges with PHP

- ❗ API key it's **required** [**Get here**](https://dashboard.capsolver.com/passport/register?inviteCode=CHhA_5os)

[![](https://img.shields.io/badge/documentation-docs.capsolver.com-darkgreen)](https://docs.capsolver.com/guide/getting-started.html)

## Install

`composer require lfsaga/capsolver-php`

## Usage

- Initialize and use `Solver` and `SolverException`
- Example:

```php
<?php

set_time_limit(610);

require_once __DIR__ . '/../vendor/autoload.php';

use Solver\Solver;
use Dotenv\Dotenv;

$solver = new Solver([
    'apiKey' => $_ENV['APIKEY']
]);

try {
    $results = $solver->turnstileproxyless([
        'websiteURL' => 'https://peet.ws/turnstile-test/non-interactive.html',
        'websiteKey' => '...',
        'metadata' => [
            'action' => 'login',
            'cdata' => 'xxxx-xxxx-xxxx-xxxx-example-cdata'
        ]
    ]);

    echo json_encode($results, JSON_PRETTY_PRINT) . "\n";
} catch (\Exception $e) {
    if ($e instanceof \Solver\Exceptions\SolverException) {
        echo "\033[31m" . $e->getTaskId() . " - " . $e->getErrorCode() . " - " . $e->getErrorDescription() . "\033[0m";
    } else {
        echo "Error: " . $e->getMessage() . "\n";
    }
    exit(1);
}

exit(0);
```

- Debug custom implementation parameters to send.
- When provide `proxy` is required, match the following pattern: `ip:port:user:pass`

## 📁 Updated examples

**Figure out [here](https://github.com/0qwertyy/capsolver-php/tree/master/examples).**

## 🔨 Supported Methods

- `$solver->visionengine([])`
- `$solver->mtcaptcha([])`
- `$solver->image2text([])`
- `$solver->recaptchav2classification([])`
- `$solver->recaptchav2([])`
- `$solver->recaptchav2proxyless([])`
- `$solver->recaptchav2enterprise([])`
- `$solver->recaptchav2enterpriseproxyless([])`
- `$solver->recaptchav3([])`
- `$solver->recaptchav3proxyless([])`
- `$solver->recaptchav3enterprise([])`
- `$solver->recaptchav3enterpriseproxyless([])`
- `$solver->datadome([])`
- `$solver->imperva([])`
- `$solver->geetest([])`
- `$solver->geetestproxyless([])`
- `$solver->cloudflare([])`
- `$solver->turnstileproxyless([])`
- `$solver->awswafclassification([])`
- `$solver->awswaf([])`
- `$solver->awswafproxyless([])`
- `$solver->friendlycaptchaproxyless([])`

#### Big Disclaimer

By using this package, you acknowledge and agree that:

- You are solely responsible for how you use the API and the author does not assume any liability for misuse, abuse, or violations of Capsolver’s terms of service.
- This package provides a service connector for the Capsolver API and is not affiliated.
