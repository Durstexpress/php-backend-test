<?php


namespace App\Exception;


use Exception;

abstract class ExceptionHandler
{

    /**
     * @param Exception $exception
     * @param string $errorMessage
     * @return Exception
     */
    public static function handleException($exception, $errorMessage)
    {
        switch (true) {
            case $exception instanceof NotFoundException:
                return $exception;

            default:
                $message = $errorMessage ? $errorMessage : $exception->getMessage();
                return new AppException($message);
        }
    }

}
