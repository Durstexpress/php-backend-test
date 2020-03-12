<?php

namespace App\Exception;


use Psr\Log\LogLevel;

class AppException extends \Exception implements HasLogLevelInterface
{

    /**
     * @inheritDoc
     */
    public function getLogLevel(): string
    {
        return LogLevel::CRITICAL;
    }
}
