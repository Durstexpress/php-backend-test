<?php

namespace App\Response;

use App\Entity\Drink;

/**
 * Class SuccessResponse.
 */
class SuccessResponse
{
    /**
     * @var Drink[]|Drink
     */
    public $data;

    /**
     * SuccessResponse constructor.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}
