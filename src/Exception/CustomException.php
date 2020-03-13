<?php

namespace App\Exception;

use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response;

class CustomException extends \Exception implements HasLogLevelInterface
{
    /**
     * {@inheritdoc}
     */
    public function getLogLevel(): string
    {
        return LogLevel::CRITICAL;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return Response::HTTP_SERVICE_UNAVAILABLE;
    }
}
