<?php

namespace CapSolver;

use Exception;
use CapSolver\Exception\ApiException;
use CapSolver\Exception\NetworkException;
use CapSolver\Exception\TimeoutException;
use CapSolver\Exception\ValidationException;

/**
 * Class CapSolver
 * @package CapSolver
 */
class CapSolver
{
    /**
     * API KEY
     *
     * @string
     */
    private $apiKey;

    /**
     * API server URL: http://api.capsolver.com
     *
     * @string
     */
    private $server = 'http://api.capsolver.com';

    /**
     * How long should wait for captcha result (in seconds)
     *
     * @integer
     */
    private $defaultTimeout = 120;

    /**
     * How long should wait for recaptcha result (in seconds)
     *
     * @integer
     */
    private $recaptchaTimeout = 600;

    /**
     * How often do requests to `/res.php` should be made
     * in order to check if a result is ready (in seconds)
     *
     * @integer
     */
    private $pollingInterval = 2;

    /**
     * Network client
     *
     * @resource
     */
    private $apiClient;

    /**
     * CapSolver constructor.
     * @param $options string|array
     */
    public function __construct($key, $debug=0)
    {
        if (is_string($key)) {
            $options = [
                'apiKey' => $key,
                'debugLevel' => isset($debug) ? $debug : 0,
            ];
        }

        if (!empty($options['server'])) $this->server = $options['server'];
        if (!empty($options['apiKey'])) $this->apiKey = $options['apiKey'];
        if (!empty($options['debugLevel'])) $this->debugLevel = $options['debugLevel'];
        if (!empty($options['defaultTimeout'])) $this->defaultTimeout = $options['defaultTimeout'];
        if (!empty($options['recaptchaTimeout'])) $this->recaptchaTimeout = $options['recaptchaTimeout'];
        if (!empty($options['pollingInterval'])) $this->pollingInterval = $options['pollingInterval'];

        $this->apiClient = new ApiClient($this->server);
    }

    public function setHttpClient($apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Wrapper for recognize Image To Text challenge
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function img2txt($captcha)
    {
        $captcha['type'] = 'ImageToTextTask';
        $captcha['classification'] = true;
        return $this->solve($captcha, ['timeout' => $this->defaultTimeout]);
    }

    /**
     * Wrapper for recognize HCaptcha challenge
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function hcaptchaclassification($captcha)
    {
        $captcha['type'] = 'HCaptchaClassification';
        $captcha['classification'] = true;
        return $this->solve($captcha, ['timeout' => $this->defaultTimeout]);
    }

    /**
     * Wrapper for recognize FunCaptcha challenge
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function funcaptchaclassification($captcha)
    {
        $captcha['type'] = 'FunCaptchaClassification';
        $captcha['classification'] = true;
        return $this->solve($captcha, ['timeout' => $this->defaultTimeout]);
    }

    /**
     * Wrapper for recognize Amazon WAF challenge
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function awswafclassification($captcha)
    {
        $captcha['type'] = 'AwsWafClassification';
        $captcha['classification'] = true;
        return $this->solve($captcha, ['timeout' => $this->defaultTimeout]);
    }

    /**
     * Wrapper for solving ReCaptcha
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function recaptchav2($captcha)
    {
        $captcha['type'] = 'ReCaptchaV2Task';
        return $this->solve($captcha, ['timeout' => $this->recaptchaTimeout]);
    }

    /**
     * Wrapper for solving ReCaptcha
     *
     * @param $captcha
     * @return string
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function recaptchav2proxyless($captcha)
    {
        $captcha['type'] = 'ReCaptchaV2TaskProxyless';
        return $this->solve($captcha, ['timeout' => $this->recaptchaTimeout]);
    }

    /**
     * Wrapper for solving ReCaptcha
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function recaptchav2enterprise($captcha)
    {
        $captcha['type'] = 'ReCaptchaV2EnterpriseTask';
        return $this->solve($captcha, ['timeout' => $this->recaptchaTimeout]);
    }

    /**
     * Wrapper for solving ReCaptcha
     *
     * @param $captcha
     * @return string
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function recaptchav2enterpriseproxyless($captcha)
    {
        $captcha['type'] = 'ReCaptchaV2EnterpriseTaskProxyLess';
        return $this->solve($captcha, ['timeout' => $this->recaptchaTimeout]);
    }

    /**
     * Wrapper for solving ReCaptcha
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function recaptchav3($captcha)
    {
        $captcha['type'] = 'ReCaptchaV3Task';
        return $this->solve($captcha, ['timeout' => $this->recaptchaTimeout]);
    }

    /**
     * Wrapper for solving ReCaptcha
     *
     * @param $captcha
     * @return string
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function recaptchav3proxyless($captcha)
    {
        $captcha['type'] = 'ReCaptchaV3TaskProxyLess';
        return $this->solve($captcha, ['timeout' => $this->recaptchaTimeout]);
    }

    /**
     * Wrapper for solving ReCaptcha
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function recaptchav3enterprise($captcha)
    {
        $captcha['type'] = 'ReCaptchaV3EnterpriseTask';
        return $this->solve($captcha, ['timeout' => $this->recaptchaTimeout]);
    }

    /**
     * Wrapper for solving ReCaptcha
     *
     * @param $captcha
     * @return string
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function recaptchav3enterpriseproxyless($captcha)
    {
        $captcha['type'] = 'ReCaptchaV3EnterpriseTaskProxyLess';
        return $this->solve($captcha, ['timeout' => $this->recaptchaTimeout]);
    }

    /**
     * Wrapper for solving HCaptcha
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function hcaptcha($captcha)
    {
        $captcha['type'] = 'HCaptchaTask';
        return $this->solve($captcha, ['timeout' => $this->defaultTimeout]);
    }

    /**
     * Wrapper for solving HCaptcha
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function hcaptchaproxyless($captcha)
    {
        $captcha['type'] = 'HCaptchaTaskProxyLess';
        return $this->solve($captcha, ['timeout' => $this->defaultTimeout]);
    }

    /**
     * Wrapper for solving HCaptcha
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function hcaptchaenterprise($captcha)
    {
        $captcha['type'] = 'HCaptchaEnterpriseTask';
        return $this->solve($captcha, ['timeout' => $this->defaultTimeout]);
    }

    /**
     * Wrapper for solving HCaptcha
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function hcaptchaenterpriseproxyless($captcha)
    {
        $captcha['type'] = 'HCaptchaEnterpriseTaskProxyLess';
        return $this->solve($captcha, ['timeout' => $this->defaultTimeout]);
    }

    /**
     * Wrapper for solving FunCaptcha
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function funcaptcha($captcha)
    {
        $captcha['type'] = 'FunCaptchaTask';
        return $this->solve($captcha, ['timeout' => $this->defaultTimeout]);
    }

    /**
     * Wrapper for solving FunCaptcha
     *
     * @param $captcha
     * @return string
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function funcaptchaproxyless($captcha)
    {
        $captcha['type'] = 'FunCaptchaTaskProxyLess';
        return $this->solve($captcha, ['timeout' => $this->defaultTimeout]);
    }

    /**
     * Wrapper for solving GeeTest
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function geetest($captcha)
    {
        $captcha['type'] = 'GeeTestTask';
        return $this->solve($captcha, ['timeout' => $this->defaultTimeout]);
    }

    /**
     * Wrapper for solving GeeTest
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function geetestproxyless($captcha)
    {
        $captcha['type'] = 'GeeTestTaskProxyLess';
        return $this->solve($captcha, ['timeout' => $this->defaultTimeout]);
    }

    /**
     * Wrapper for solving MtCaptcha
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function mtcaptcha($captcha)
    {
        $captcha['type'] = 'MtCaptchaTask';
        $captcha['classification'] = true;
        return $this->solve($captcha, ['timeout' => $this->defaultTimeout]);
    }

    /**
     * Wrapper for solving MtCaptcha
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function mtcaptchaproxyless($captcha)
    {
        $captcha['type'] = 'MtCaptchaTaskProxyLess';
        $captcha['classification'] = true;
        return $this->solve($captcha, ['timeout' => $this->defaultTimeout]);
    }

    /**
     * Wrapper for solving Datadome
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function datadome($captcha)
    {
        $captcha['type'] = 'DatadomeSliderTask';
        return $this->solve($captcha, ['timeout' => $this->defaultTimeout]);
    }

    /**
     * Wrapper for solving BnCaptcha
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function bncaptcha($captcha)
    {
        $captcha['type'] = 'BinanceCaptchaTask';
        return $this->solve($captcha, ['timeout' => $this->defaultTimeout]);
    }

    /**
     * Wrapper for solving Kasada
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function antikasada($captcha)
    {
        $captcha['type'] = 'AntiKasadaTask';
        return $this->solve($captcha, ['timeout' => $this->defaultTimeout]);
    }

    /**
     * Wrapper for solving AkamaiBMP
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function antiakamai($captcha)
    {
        $captcha['type'] = 'AntiAkamaiBMPTask';
        return $this->solve($captcha, ['timeout' => $this->defaultTimeout]);
    }

    /**
     * Wrapper for solving Cloudflare
     *
     * @param $captcha
     * @return \stdClass
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function anticloudflare($captcha)
    {
        $captcha['type'] = 'AntiCloudflareTask';
        return $this->solve($captcha, ['timeout' => $this->defaultTimeout]);
    }

    /**
     * Sends captcha to `/createTask` and waits for it's result.
     * This helper can be used insted of manual using of `send` and `getResult` functions.
     *
     * @param $captcha
     * @param array $waitOptions
     * @return string
     * @throws ApiException
     * @throws NetworkException
     * @throws TimeoutException
     * @throws ValidationException
     */
    public function solve($captcha, $waitOptions = [])
    {
        $result = new \stdClass();

        if(isset($captcha['classification']) && $captcha['classification'] === true){
            unset($captcha['classification']);
            return $this->send($captcha, true);
        }

        $result->taskId = $this->send($captcha);

        $result->solution = $this->waitForResult($result->taskId, $waitOptions);

        return $result->solution;
    }

    /**
     * This helper waits for captcha result, and when result is ready, returns it
     *
     * @param $id
     * @param array $waitOptions
     * @return string|null
     * @throws TimeoutException
     */
    public function waitForResult($id, $waitOptions = [])
    {
        $startedAt = time();

        $timeout = empty($waitOptions['timeout']) ? $this->defaultTimeout : $waitOptions['timeout'];
        $pollingInterval = empty($waitOptions['pollingInterval']) ? $this->pollingInterval : $waitOptions['pollingInterval'];

        while (true) {
            if (time() - $startedAt < $timeout) {
                sleep($pollingInterval);
            } else {
                break;
            }

            try {
                $response = $this->getResult($id);
                if ($response->status === 'ready') return $response->solution;
            } catch (NetworkException $e) {
                // ignore network errors
            } catch (Exception $e) {
                throw $e;
            }
        }

        throw new TimeoutException('Timeout ' . $timeout . ' seconds reached');
    }

    /**
     * Sends captcha to '/createTask', and returns its `id`
     *
     * @param $captcha
     * @return string
     * @throws ApiException
     * @throws NetworkException
     * @throws ValidationException
     */
    public function send($captcha, $classification=null)
    {
        $files = $this->extractFiles($captcha);

        $task = $this->wrapAttachDefaultParams($captcha);

        $response = $this->apiClient->createTask($task, $files);

        $info = json_decode($response);

        if(isset($this->debugLevel) && $this->debugLevel > 0){
            echo '['.$captcha['type'].'][new task: '.json_decode($response)->taskId.']'.PHP_EOL;
        }

        if(isset($classification) && $classification === true){
            return $info;
        }else{
            return $info->taskId;
        }

    }

    /**
     * Returns result of captcha if it was solved or `null`, if result is not ready
     *
     * @param $id
     * @return string|null
     * @throws ApiException
     * @throws NetworkException
     */
    public function getResult($id)
    {
        $response = $this->getTaskResult($id);

        $info = json_decode($response);

        if ($info->errorId !== 0) {
            throw new ApiException('Cannot recognise api response (' . $response . ')');
        }

        if(isset($this->debugLevel) && $this->debugLevel > 0){
            echo '['.$id.'][status: '.$info->status.']'.PHP_EOL;
        }

        return $info;
    }

    /**
     * Gets account's balance
     *
     * @return float
     * @throws ApiException
     * @throws NetworkException
     */
    public function balance()
    {
        $response = $this->apiClient->getBalance($this->apiKey);
        $info = json_decode($response);
        return floatval($info->balance);
    }

    /**
     * Makes request to `/getTaskResult`
     *
     * @param $query
     * @return bool|string
     * @throws ApiException
     * @throws NetworkException
     */
    private function getTaskResult($taskId)
    {
        $info = [ 'taskId' => $taskId, 'clientKey' => $this->apiKey ];

        return $this->apiClient->getTaskResult($info);
    }

    /**
     * Attaches default parameters (passed in constructor) to request
     *
     * @param $captcha
     * @return array
     */
    private function wrapAttachDefaultParams(&$captcha)
    {
        return [ 'clientKey' => $this->apiKey, 'appId' => '8C9E51E4-7D28-4DC8-AD15-E2C1B211EE4F', 'task' => $captcha ];
    }

    /**
     * Extracts files into separate array
     *
     * @param $captcha
     * @return array
     */
    private function extractFiles(&$captcha)
    {
        $files = [];

        $fileKeys = ['file', 'hintImg'];

        for ($i = 1; $i < 10; $i++) {
            $fileKeys[] = 'file_' . $i;
        }

        foreach ($fileKeys as $key) {
            if (!empty($captcha[$key]) and is_file($captcha[$key])) {
                $files[$key] = $captcha[$key];
                unset($captcha[$key]);
            }
        }

        return $files;
    }

}
