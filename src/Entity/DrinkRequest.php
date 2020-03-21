<?php

namespace App\Entity;

use App\Service\DrinkTypeService;
use JMS\Serializer\Annotation as Serializer;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class DrinkRequest.
 */
class DrinkRequest
{
    use DrinkDetail;

    /**
     * @var int
     * @Assert\NotBlank()
     * @SWG\Property(description="A valid drink type ID")
     * @Serializer\Type("int")
     */
    private $typeId;

    public function getTypeId(): int
    {
        return $this->typeId;
    }

    /**
     * @param DrinkTypeService $drinkTypeService
     * @param Drink            $drink
     *
     * @throws \Exception
     */
    public function getDrink($drinkTypeService, ?Drink $drink = null): Drink
    {
        if (!$drink) {
            $drink = new Drink();
        }
        $drink->setName($this->getName());
        $drink->setContainsAlcohol($this->getContainsAlcohol());
        $drink->setPrice($this->getPrice());
        $drink->setBottleDepositPrice($this->getBottleDepositPrice());
        $drink->setPackage($this->getPackage());

        // Query optimization to make sure we don't
        // query drinkType table if drinkTypeId did not change
        if (!$drink->getType() || ($drink->getType()->getId() !== $this->getTypeId())) {
            $drink->setType($drinkTypeService->getDrinkTypeById($this->getTypeId()));
        }

        return $drink;
    }
}
