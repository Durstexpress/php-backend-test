<?php

namespace App\Controller\Api;

use App\Entity\Drink;
use App\Entity\DrinkRequest;
use App\Exception\FormValidationException;
use App\Service\DrinkService;
use App\Service\DrinkTypeService;
use Exception;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class DrinkController.
 */
class DrinkController extends BaseController
{
    /** @var DrinkService */
    private $drinkService;

    /** @var DrinkTypeService */
    private $drinkTypeService;

    public function __construct(DrinkService $drinkService, DrinkTypeService $drinkTypeService)
    {
        $this->drinkService = $drinkService;
        $this->drinkTypeService = $drinkTypeService;
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Returns a list of all the drinks.",
     *     @SWG\Schema(
     *         @SWG\Property(
     *             property="data",
     *             type="array",
     *             @SWG\Items(ref=@Model(type=Drink::class))
     *         )
     *     )
     * )
     *
     * @throws Exception
     */
    public function getDrinksAction(): Response
    {
        return $this->respondSuccess(
            $this->drinkService->getAllDrinks()
        );
    }

    /**
     * @Post("/drinks")
     * @ParamConverter("drinkRequest", converter="fos_rest.request_body")
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Request Body",
     *     required=true,
     *     @Model(type=DrinkRequest::class)
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns the created drink.",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="data", ref=@Model(type=Drink::class))
     *     )
     * )
     *
     * @throws FormValidationException
     * @throws Exception
     */
    public function postDrinksAction(
        DrinkRequest $drinkRequest,
        ConstraintViolationListInterface $validationErrors
    ): Response {
        if (count($validationErrors) > 0) {
            throw new FormValidationException($validationErrors);
        }

        $drink = $drinkRequest->getDrink($this->drinkTypeService);

        return $this->respondSuccess(
            $this->drinkService->createDrink($drink)
        );
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Returns the drink with the specified ID",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="data", ref=@Model(type=Drink::class))
     *     )
     * )
     *
     * @throws Exception
     */
    public function getDrinkAction(int $id): Response
    {
        return $this->respondSuccess(
            $this->drinkService->getDrinkById($id)
        );
    }

    /**
     * @Put("/drinks/{id}")
     * @ParamConverter("drinkRequest", converter="fos_rest.request_body")
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Request Body",
     *     required=true,
     *     @Model(type=DrinkRequest::class)
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns the updated drink.",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="data", ref=@Model(type=Drink::class))
     *     )
     * )
     *
     * @return Response
     *
     * @throws FormValidationException
     * @throws Exception
     */
    public function putDrinkAction(
        int $id,
        DrinkRequest $drinkRequest,
        ConstraintViolationListInterface $validationErrors
    ) {
        if (count($validationErrors) > 0) {
            throw new FormValidationException($validationErrors);
        }

        $drink = $drinkRequest->getDrink(
            $this->drinkTypeService,
            $this->drinkService->getDrinkById($id)
        );

        return $this->respondSuccess(
            $this->drinkService->createDrink($drink)
        );
    }

    /**
     * @throws Exception
     */
    public function deleteDrinkAction(int $id): Response
    {
        $this->drinkService->deleteDrinkById($id);

        return $this->respond([], Response::HTTP_NO_CONTENT);
    }
}
