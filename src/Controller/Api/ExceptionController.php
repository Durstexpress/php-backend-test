<?php

namespace App\Controller\Api;

use App\Exception\AppException;
use App\Exception\CustomException;
use App\Exception\HasFormErrorInterface;
use App\Exception\NotFoundException;
use App\Response\BadResponse;
use App\Response\FormValidationResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ExceptionController.
 */
class ExceptionController extends BaseController
{
    public function handleException(Request $request): Response
    {
        $parameters = $request->attributes;
        /** @var CustomException $exception */
        $exception = $parameters->get('exception');

        switch (true) {
            case $exception instanceof NotFoundHttpException:
                $data = new BadResponse('Endpoint NotFound');
                $statusCode = Response::HTTP_NOT_FOUND;
                break;

            case $exception instanceof NotFoundException:
            case $exception instanceof AppException:
                $data = new BadResponse($exception->getMessage());
                $statusCode = $exception->getStatusCode();
                break;

            case $exception instanceof HasFormErrorInterface:
                $data = new FormValidationResponse(
                    $exception->getMessage(),
                    $exception->getErrors()
                );
                $statusCode = $exception->getStatusCode();
                break;

            default:
                $data = new BadResponse('An error has happened');
                $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $this->respond($data, $statusCode);
    }
}
