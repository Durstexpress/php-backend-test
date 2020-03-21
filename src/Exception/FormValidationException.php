<?php

namespace App\Exception;

use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class FormValidationException extends CustomException implements HasFormErrorInterface
{
    /**
     * @var array
     */
    private $errors;

    public function __construct(ConstraintViolationListInterface $violationLists)
    {
        parent::__construct('A validation error has occurred');
        $this->setErrors(
            $this->getMessagesFromViolations($violationLists)
        );
    }

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
        return Response::HTTP_BAD_REQUEST;
    }

    /**
     * {@inheritdoc}
     */
    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * {@inheritdoc}
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    private function getMessagesFromViolations(ConstraintViolationListInterface $violationLists): array
    {
        $errorMessages = [];

        /** @var ConstraintViolationInterface $constraint */
        foreach ($violationLists as $constraint) {
            $prop = $constraint->getPropertyPath();
            $errorMessages[$prop][] = $constraint->getMessage();
        }

        return $errorMessages;
    }
}
