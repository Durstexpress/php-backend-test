<?php

namespace App\Response;

/**
 * Class BadResponse.
 */
class FormValidationResponse extends BadResponse
{
    /**
     * @var array
     */
    public $errors;

    /**
     * FormValidationResponse constructor.
     *
     * @param $errors
     */
    public function __construct($message, $errors)
    {
        parent::__construct($message);
        $this->errors = $errors;
    }
}
