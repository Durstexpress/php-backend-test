<?php

namespace App\Response;

/**
 * Class BadResponse.
 */
class BadResponse
{
    /**
     * @var string
     */
    public $message;

    /**
     * BadResponse constructor.
     *
     * @param $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }
}
