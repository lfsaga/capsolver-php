# PHP Module for CapSolver API
The easiest way to quickly integrate [CapSolver] captcha solving service into your code to automate solving of any types of captcha.
- ❗ An API key it's **required**. [**Get here.**](https://dashboard.capsolver.com/passport/register?inviteCode=CHhA_5os)

[![](https://img.shields.io/badge/documentation-docs.capsolver.com-blue)](https://docs.capsolver.com/guide/getting-started.html)
## Installation
This package can be installed via composer or manually

### Composer
```
composer require 0qwertyy/capsolver-php:dev-master
```

### Manual
Copy `src` directory to your project and then `require` autoloader (`src/autoloader.php`) where needed:
```php
require 'path/to/autoloader.php';
```

## Configuration
`CapSolver` instance can be created like this:

```php
$solver = new \CapSolver\CapSolver('CAI-XXX...');
```
Also there are few options that can be configured:

```php
$solver = new \CapSolver\CapSolver([
    'apiKey'           => 'CAI-XXX...',
    'defaultTimeout'   => 120,
    'recaptchaTimeout' => 600,
    'pollingInterval'  => 10,
]);
```

### CapSolver instance options

|Option|Default value|Description|
|---|---|---|
|defaultTimeout|120|Polling timeout in seconds for all captcha types except ReCaptcha. Defines how long the module tries to get the answer from `getTaskResult` API endpoint|
|recaptchaTimeout|600|Polling timeout for ReCaptcha in seconds. Defines how long the module tries to get the answer from `getTaskResult` API endpoint|
|pollingInterval|10|Interval in seconds between requests to `getTaskResult` API endpoint, setting values less than 5 seconds is not recommended|

> To get the answer manually use [getResult method](#send--getresult)

## Solve a captcha

### Call example
Use this method to solve ReCaptcha V2 and obtain a token to bypass the protection.
```php
$result = $solver->recaptchav2([
        'websiteKey'    => 'XxX-XXXXXXxXXXXXXXXXXxXXXXX',                   // grab it from target site
        'websiteURL'    => 'https://www.mysite.com/recaptcha/api2/demo',    // grab it from target site
        'proxy'         => 'proxy.provider.io:23331:user1:password1',       // proxy string format
]);
```

## Manual polling

### send / getResult
These methods can be used for manual captcha submission and answer polling.
```php
$id = $solver->send(['type' => 'HCaptchaTask', ...]);
sleep(20);

$code = $solver->getResult($id);
```
### balance
Use this method to get your account's balance
```php
$balance = $solver->balance();
```

## Error handling
If case of an error captcha solver throws an exception. It's important to properly handle these cases. We recommend to use `try catch` to handle exceptions. 
```php
try {
    $result = $solver->recaptchav2([
            'websiteKey'    => 'XxX-XXXXXXxXXXXXXXXXXxXXXXX',                   // grab it from target site
            'websiteURL'    => 'https://www.mysite.com/recaptcha/api2/demo',    // grab it from target site
            'proxy'         => 'proxy.provider.io:23331:user1:password1',       // proxy string format
    ]);
} catch (\CapSolver\Exception\ValidationException $e) {
    // invalid parameters passed
} catch (\CapSolver\Exception\NetworkException $e) {
    // network error occurred
} catch (\CapSolver\Exception\ApiException $e) {
    // api respond with error
} catch (\CapSolver\Exception\TimeoutException $e) {
    // captcha is not solved so far
}
```

## 📁 Examples directory
**Figure out all the working examples [here](https://github.com/0qwertyy/capsolver-php/tree/master/examples).**

[CapSolver]: https://capsolver.com/
