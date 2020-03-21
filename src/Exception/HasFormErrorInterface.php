<?php

namespace App\Exception;

interface HasFormErrorInterface
{
    public function setErrors(array $errors): void;

    public function getErrors(): array;
}
