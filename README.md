# capsolver-php

manage to solve captcha challenges with PHP

- ❗ API key it's **required** [**Get here**](https://dashboard.capsolver.com/passport/register?inviteCode=CHhA_5os)

[![](https://img.shields.io/badge/documentation-docs.capsolver.com-darkgreen)](https://docs.capsolver.com/guide/getting-started.html)

## Install

`composer require lfsaga/capsolver-php`

## Usage

- Initialize and use `Solver` and `SolverException`
- TS example:

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

**Figure out [here](https://github.com/0qwertyy/capsolver-npm/tree/master/examples).**

## 🔨 Supported Methods

- Consider `null` as an optional parameter.
- Refer to the official documentation for more details.

[**_Solving AwsWaf with Classification ..._**](https://docs.capsolver.com/en/guide/recognition/AwsWafClassification/) | [**_Solving AwsWaf ..._**](https://docs.capsolver.com/en/guide/captcha/awsWaf/)

```javascript
await solver.awswafclassification({
  websiteURL: null,
  images,
  question,
});

await solver.awswaf({
  proxy,
  websiteURL,
  awsKey: null,
  awsIv: null,
  awsContext: null,
  awsChallengeJS: null,
});

await solver.awswafproxyless({
  websiteURL,
  awsKey: null,
  awsIv: null,
  awsContext: null,
  awsChallengeJS: null,
});
```

[**_Solving DataDome ..._**](https://docs.capsolver.com/en/guide/captcha/datadome/)

```javascript
await solver.datadome({
  proxy,
  websiteURL,
  captchaUrl,
  userAgent,
});
```

[**_Solving FriendlyCaptcha ..._**](https://docs.capsolver.com/en/guide/captcha/FriendlyCaptcha/)

```javascript
await solver.friendlycaptchaproxyless({
  websiteURL,
  websiteKey,
});
```

[**_Solving GeeTest ..._**](https://docs.capsolver.com/en/guide/captcha/Geetest/)

```javascript
await solver.geetest({
  proxy,
  websiteURL,
  gt,
  challenge,
  captchaId: null,
  geetestApiServerSubdomain: null,
});

await solver.geetestproxyless({
  websiteURL,
  gt,
  challenge,
  captchaId: null,
  geetestApiServerSubdomain: null,
});
```

[**_Solving ImageToText ..._**](https://docs.capsolver.com/guide/recognition/ImageToTextTask.html)

```javascript
await solver.image2text({
  body,
  module: null,
  score: null,
});
```

[**_Solving Imperva ..._**](https://docs.capsolver.com/guide/antibots/datadome.html)

```javascript
await solver.imperva({
  websiteURL,
  reeseScriptURL,
});
```

[**_Solving MTCaptcha ..._**](https://docs.capsolver.com/guide/captcha/MtCaptcha.html)

```javascript
await solver.mtcaptcha({
  proxy,
  websiteURL,
  websiteKey,
});
```

[**_Solving ReCaptchaV2 with Classification ..._**](https://docs.capsolver.com/en/guide/recognition/ReCaptchaClassification/) | [**_Solving ReCaptchaV2 / Enterprise ..._**](https://docs.capsolver.com/en/guide/captcha/ReCaptchaV2/)

```javascript
await solver.recaptchav2classification({
  websiteURL: null,
  question,
  image,
});

await solver.recaptchav2({
  proxy,
  websiteURL,
  websiteKey,
  userAgent: null,
  isInvisible: null,
  pageAction: null,
  enterprisePayload: null,
  apiDomain: null,
  cookies: null,
});

await solver.recaptchav2proxyless({
  websiteURL,
  websiteKey,
  userAgent: null,
  isInvisible: null,
  pageAction: null,
  enterprisePayload: null,
  apiDomain: null,
  cookies: null,
});

await solver.recaptchav2enterprise({
  proxy,
  websiteURL,
  websiteKey,
  userAgent: null,
  enterprisePayload: null,
  apiDomain: null,
  cookies: null,
});

await solver.recaptchav2enterpriseproxyless({
  websiteURL,
  websiteKey,
  userAgent: null,
  enterprisePayload: null,
  apiDomain: null,
  cookies: null,
});
```

[**_Solving ReCaptchaV3 / Enterprise ..._**](https://docs.capsolver.com/guide/captcha/ReCaptchaV3.html)

```javascript
await solver.recaptchav3({
  proxy,
  websiteURL,
  websiteKey,
  pageAction,
  enterprisePayload: null,
  apiDomain: null,
  cookies: null,
});

await solver.recaptchav3proxyless({
  websiteURL,
  websiteKey,
  pageAction,
  enterprisePayload: null,
  apiDomain: null,
  cookies: null,
});

await solver.recaptchav3enterprise({
  proxy,
  websiteURL,
  websiteKey,
  pageAction,
  enterprisePayload: null,
  apiDomain: null,
  cookies: null,
});

await solver.recaptchav3enterpriseproxyless({
  websiteURL,
  websiteKey,
  pageAction,
  enterprisePayload: null,
  apiDomain: null,
  cookies: null,
});
```

[**_Solving Turnstile ..._**](https://docs.capsolver.com/en/guide/captcha/cloudflare_turnstile/)

```javascript
await solver.turnstileproxyless({
  websiteURL,
  websiteKey,
  metadata: null,
});
```

[**_Solving VisionEngine ..._**](https://docs.capsolver.com/en/guide/recognition/VisionEngine/)

```javascript
await solver.visionengine({
  websiteURL: null,
  module,
  image,
  imageBackground,
  question: null,
});
```

#### Big Disclaimer

By using this package, you acknowledge and agree that:

- You are solely responsible for how you use the API and the author does not assume any liability for misuse, abuse, or violations of Capsolver’s terms of service.
- This package provides a service connector for the Capsolver API and is not affiliated.
