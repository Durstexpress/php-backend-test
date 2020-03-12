<?php

namespace App\Exception;


use Psr\Log\LogLevel;

class NotFoundException extends \Exception implements HasLogLevelInterface
{

    /**
     * @inheritDoc
     */
    public function getLogLevel(): string
    {
        return LogLevel::INFO;
    }
}
