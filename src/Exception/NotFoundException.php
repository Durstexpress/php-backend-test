<?php

namespace App\Exception;

use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response;

class NotFoundException extends CustomException
{
    /**
     * {@inheritdoc}
     */
    public function getLogLevel(): string
    {
        return LogLevel::INFO;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return Response::HTTP_NOT_FOUND;
    }
}
