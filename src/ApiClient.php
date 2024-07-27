<?php

namespace CapSolver;

use CapSolver\Exception\ApiException;
use CapSolver\Exception\NetworkException;

class ApiClient
{
    /**
     * API server
     *
     * @var string
     */
    private $server;

    /**
     * ApiClient constructor.
     * @param $options string
     */
    public function __construct($options) {
        if (is_string($options)) {
            $this->server = $options;
        }
    }

    /**
     * Network client
     *
     * @resource
     */
    private $curl;

    /**
     * Retrieve balance as float value
     *
     * @param $captcha
     * @param array $files
     * @return bool|string
     * @throws ApiException
     * @throws NetworkException
     */
    public function getBalance($apiKey)
    {
        if (!$this->curl) $this->curl = curl_init();

        curl_setopt_array($this->curl, [
            CURLOPT_URL            => $this->server . '/getBalance',
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode(['clientKey' => $apiKey]),
        ]);

        return $this->execute();
    }

    /**
     * Sends captcha to /createTask
     *
     * @param $captcha
     * @param array $files
     * @return bool|string
     * @throws ApiException
     * @throws NetworkException
     */
    public function createTask($captcha, $files = [])
    {
        if (!$this->curl) $this->curl = curl_init();

        foreach ($files as $key => $file) {
            $captcha[$key] = $this->curlPrepareFile($file);
        }

        curl_setopt_array($this->curl, [
            CURLOPT_URL            => $this->server . '/createTask',
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS     => json_encode($captcha),
        ]);

        return $this->execute();
    }

    /**
     * Does request to /getTaskResult
     *
     * @param $query
     * @return bool|string
     * @throws ApiException
     * @throws NetworkException
     */
    public function getTaskResult($info)
    {
        if (!$this->curl) $this->curl = curl_init();

        curl_setopt_array($this->curl, [
            CURLOPT_URL            => $this->server . '/getTaskResult',
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($info),
        ]);

        return $this->execute();
    }

    /**
     * Executes http request to api
     *
     * @return bool|string
     * @throws ApiException
     * @throws NetworkException
     */
    private function execute()
    {
        $response = curl_exec($this->curl);

        if (curl_errno($this->curl)) {
            throw new NetworkException(curl_error($this->curl));
        }

        // check errorId
        if (json_decode($response)->errorId !== 0) {
            if(isset(json_decode($response)->errorCode)){
                if(isset(json_decode($response)->errorDescription)){
                    throw new ApiException(json_decode($response)->errorDescription);
                }else{
                    throw new ApiException(json_decode($response)->errorCode);
                }
            }else{
                throw new ApiException('UNHANDLED_ERROR');
            }
        }

        return $response;
    }

    /**
     * Different php versions have different approaches of sending files via CURL
     *
     * @param $file
     * @return \CURLFile|string
     */
    private function curlPrepareFile($file)
    {
        if (function_exists('curl_file_create')) { // php 5.5+
            return curl_file_create($file, mime_content_type($file), 'file');
        } else {
            return '@' . realpath($file);
        }
    }

    /**
     * Closes active CURL resource if it was created
     */
    public function __destruct()
    {
        if ($this->curl) {
            curl_close($this->curl);
        }
    }
}
