<?php

namespace Solver;

use Solver\Exceptions\SolverException;
use GuzzleHttp\Client;
use Dotenv\Dotenv;

class Solver
{
    private string $apiKey;
    private int $pollDelay;
    private Client $client;

    public function __construct(array $config = [])
    {
        if (file_exists(dirname(__DIR__) . '/.env')) {
            $dotenv = Dotenv::createImmutable(dirname(__DIR__));
            $dotenv->load();
        }

        $this->apiKey = $config['apiKey'] ?? $_ENV['APIKEY'] ?? '';
        $this->pollDelay = $config['pollDelay'] ?? 1700;
        $this->client = new Client(['base_uri' => 'https://api.capsolver.com/']);
    }

    public function balance(): float
    {
        try {
            $response = $this->client->post('getBalance', [
                'json' => ['clientKey' => $this->apiKey]
            ]);

            $data = json_decode($response->getBody(), true);

            if ($data['errorId'] !== 0) {
                throw new SolverException('Failed to retrieve balance', $data);
            }

            return (float)($data['balance'] ?? 0);
        } catch (\Exception $e) {
            if ($e instanceof SolverException) {
                throw $e;
            }
            throw new SolverException('Unexpected error retrieving balance', [
                'errorCode' => 'BALANCE_ERROR',
                'errorDescription' => $e->getMessage()
            ]);
        }
    }

    public function task(array $options): array
    {
        $task = $options['task'] ?? [];
        $mustPoll = $options['mustPoll'] ?? true;

        if (empty($task['type'])) {
            throw new \TypeError(
                'Type of task is required. Please provide a valid task type. (e.g. RecaptchaV2Task)'
            );
        }

        try {
            $handler = new Handler([
                'task' => $task,
                'apiKey' => $this->apiKey,
                'mustPoll' => $mustPoll
            ]);

            return $handler->execute($this->pollDelay);
        } catch (\Exception $e) {
            if ($e instanceof SolverException) {
                throw $e;
            }
            throw new SolverException('Unexpected error in task execution', [
                'errorCode' => 'TASK_EXECUTION_ERROR',
                'errorDescription' => $e->getMessage()
            ]);
        }
    }

    public function visionengine(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'VisionEngine'], $params),
            'mustPoll' => false
        ]);
    }

    public function mtcaptcha(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'MTCaptchaTask'], $params)
        ]);
    }

    public function image2text(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'ImageToTextTask'], $params),
            'mustPoll' => false
        ]);
    }

    public function recaptchav2classification(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'ReCaptchaV2Classification'], $params),
            'mustPoll' => false
        ]);
    }

    public function recaptchav2(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'RecaptchaV2Task'], $params)
        ]);
    }

    public function recaptchav2proxyless(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'RecaptchaV2TaskProxyless'], $params)
        ]);
    }

    public function recaptchav2enterprise(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'RecaptchaV2EnterpriseTask'], $params)
        ]);
    }

    public function recaptchav2enterpriseproxyless(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'RecaptchaV2EnterpriseTaskProxyless'], $params)
        ]);
    }

    public function recaptchav3(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'RecaptchaV3Task'], $params)
        ]);
    }

    public function recaptchav3proxyless(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'RecaptchaV3TaskProxyless'], $params)
        ]);
    }

    public function recaptchav3enterprise(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'RecaptchaV3EnterpriseTask'], $params)
        ]);
    }

    public function recaptchav3enterpriseproxyless(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'RecaptchaV3EnterpriseTaskProxyless'], $params)
        ]);
    }

    public function datadome(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'DataDomeSliderTask'], $params)
        ]);
    }

    public function imperva(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'AntiImpervaTaskProxyless'], $params)
        ]);
    }

    public function geetest(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'GeeTestTask'], $params)
        ]);
    }

    public function geetestproxyless(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'GeeTestTaskProxyless'], $params)
        ]);
    }

    public function cloudflare(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'AntiCloudflareTask'], $params)
        ]);
    }

    public function turnstileproxyless(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'AntiTurnstileTaskProxyless'], $params)
        ]);
    }

    public function awswafclassification(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'AwsWafClassification'], $params),
            'mustPoll' => false
        ]);
    }

    public function awswaf(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'AntiAwsWafTask'], $params)
        ]);
    }

    public function awswafproxyless(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'AntiAwsWafTaskProxyless'], $params)
        ]);
    }

    public function friendlycaptchaproxyless(array $params): array
    {
        return $this->task([
            'task' => array_merge(['type' => 'FriendlyCaptchaTaskProxyless'], $params)
        ]);
    }
}
