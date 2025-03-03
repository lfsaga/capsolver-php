<?php

namespace Solver\Exceptions;

class SolverException extends \Exception
{
    private array $errorData;

    public function __construct(string $message, array $errorData = [])
    {
        parent::__construct($message);
        $this->errorData = $errorData;
    }

    public function getErrorData(): array
    {
        return $this->errorData;
    }

    public function getErrorCode(): string
    {
        return $this->getErrorData()['errorCode'] ?? '';
    }

    public function getErrorDescription(): string
    {
        return $this->getErrorData()['errorDescription'] ?? '';
    }

    public function getTaskId(): string
    {
        return $this->getErrorData()['taskId'] ?? '';
    }
}
