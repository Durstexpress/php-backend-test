<?php

namespace App\Controller\Api;

use App\Entity\Drink;
use App\Service\DrinkService;
use Exception;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DrinkController.
 */
class DrinkController extends BaseController
{
    /** @var DrinkService */
    private $drinkService;

    public function __construct(DrinkService $drinkService)
    {
        $this->drinkService = $drinkService;
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

    public function postDrinksAction()
    {
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

    public function putDrinkAction(int $id)
    {
    }

    public function deleteDrinkAction(int $id)
    {
    }
}
