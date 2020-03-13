<?php

namespace App\Controller\Api;

use App\Response\SuccessResponse;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BaseController.
 */
class BaseController extends AbstractFOSRestController
{
    /**
     * @param $data
     * @param $statusCode
     */
    public function respond($data, $statusCode): Response
    {
        return $this->handleView(
            $this->view($data, $statusCode)
        );
    }

    /**
     * @param $data
     * @param int $statusCode
     */
    public function respondSuccess($data, $statusCode = Response::HTTP_OK): Response
    {
        return $this->respond(
            new SuccessResponse($data),
            $statusCode
        );
    }
}
