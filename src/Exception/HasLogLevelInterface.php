<?php

namespace App\Exception;

interface HasLogLevelInterface
{
    /**
     * @return string A log level From this Psr\Log\LogLevel
     */
    public function getLogLevel(): string;
}
