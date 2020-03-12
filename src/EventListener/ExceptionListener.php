<?php


namespace App\EventListener;


use App\Exception\HasLogLevelInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LogLevel;
use Psr\Log\NullLogger;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
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

        $response = new Response();

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // sends the modified response object to the event
        $event->setResponse($response);
    }

    /**
     * @param Throwable $exception
     *
     * @return string
     */
    private function getLogLevel(Throwable $exception)
    {
        if ($exception instanceof HasLogLevelInterface) {
            return $exception->getLogLevel();
        }

        return self::DEFAULT_LOG_LEVEL;
    }

    /**
     * Logs an exception.
     *
     * @param Throwable $exception
     */
    private function logException(Throwable $exception)
    {
        $this->logger->log(
            $this->getLogLevel($exception),
            $exception->getMessage(),
            ["exception" => $exception]
        );
    }

}
