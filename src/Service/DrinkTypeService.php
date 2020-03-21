<?php

namespace App\Service;

use App\Entity\DrinkType;
use App\Exception\ExceptionHandler;
use App\Exception\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class DrinkTypeService extends GenericService
{
    /**
     * DrinkTypeService constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, DrinkType::class);
    }

    /**
     * @throws Exception
     */
    public function getDrinkTypeById(int $drinkTypeId): DrinkType
    {
        try {
            /** @var DrinkType $drinkType */
            $drinkType = $this->getRepository()->find($drinkTypeId);

            if (null === $drinkType) {
                throw new NotFoundException(sprintf('Drink Type with ID s was not found', $drinkTypeId));
            }

            return $drinkType;
        } catch (Exception $exception) {
            throw ExceptionHandler::handleException($exception, 'Error getting drink type by ID.');
        }
    }
}
