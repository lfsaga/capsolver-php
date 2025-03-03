<?php

namespace Solver;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

use Solver\Exceptions\SolverException;

class Handler
{
    private array $t;
    private string $k;
    private bool $mp;
    private Client $client;

    public function __construct(array $config)
    {
        $this->t = $config['task'];
        $this->k = $config['apiKey'];
        $this->mp = $config['mustPoll'] ?? true;
        $this->client = new Client([
            'base_uri' => 'https://api.capsolver.com/',
            RequestOptions::HTTP_ERRORS => false
        ]);
    }

    public function execute(int $pollDelay): array
    {
        try {
            if ($this->mp) {
                return $this->poll($this->create()['taskId'], $pollDelay);
            } else {
                $res = $this->create();
                return $res['solution'] ?? $res;
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function create(): array
    {
        $res = $this->client->post('createTask', [
            'json' => [
                'clientKey' => $this->k,
                'appId' => 'AF0F28E5-8245-49FD-A3FD-43D576C0E9B3',
                'task' => $this->t
            ]
        ]);

        $data = json_decode($res->getBody(), true);

        if ($data['errorId'] !== 0) {
            throw new SolverException('Failed to create task', $data);
        }

        return $data;
    }

    private function poll(string $tid, int $pd): array
    {
        $tries = 0;
        while ($tries <= 50) {
            $res = $this->client->post('getTaskResult', [
                'json' => [
                    'clientKey' => $this->k,
                    'taskId' => $tid
                ]
            ]);

            $data = json_decode($res->getBody(), true);

            if ($data['errorId'] !== 0) {
                throw new SolverException('Failed to retrieve task solution', $data);
            }

            if ($data['status'] === 'ready') {
                return $data['solution'] ?? $data;
            }

            usleep($pd * 1000); // Convert to microseconds
            $tries++;
        }

        throw new SolverException('Failed retrieving task solution. Error threshold exceeded.', [
            'taskId' => $tid
        ]);
    }
}
