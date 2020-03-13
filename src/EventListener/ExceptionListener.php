<?php

namespace App\EventListener;

use App\Exception\HasLogLevelInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LogLevel;
use Psr\Log\NullLogger;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;

class ExceptionListener implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    const DEFAULT_LOG_LEVEL = LogLevel::CRITICAL;

    /**
     * ExceptionListener constructor.
     */
    public function __construct()
    {
        $this->logger = new NullLogger();
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        $this->logException($exception);
    }

    private function getLogLevel(Throwable $exception): string
    {
        if ($exception instanceof HasLogLevelInterface) {
            return $exception->getLogLevel();
        }

        return self::DEFAULT_LOG_LEVEL;
    }

    /**
     * Logs an exception.
     */
    private function logException(Throwable $exception)
    {
        $this->logger->log(
            $this->getLogLevel($exception),
            $exception->getMessage(),
            ['exception' => $exception]
        );
    }
}
