<?php

namespace App\Service;

use App\Entity\Drink;
use App\Repository\DrinkRepository;

class DrinkService
{
    /** @var DrinkRepository $drinkRepository */
    private $drinkRepository;

    public function __construct(DrinkRepository $drinkRepository)
    {
        $this->drinkRepository = $drinkRepository;
    }

    /**
     * @param Drink $drink
     * @return Drink
     */
    public function createDrink(Drink $drink): Drink
    {
        return $this->drinkRepository->persist($drink);
    }

    /**
     * @return Drink[]
     */
    public function getAllDrinks()
    {
        return $this->drinkRepository->findAll();
    }

    /**
     * @param int $id
     * @return Drink|null
     */
    public function findDrinkById(int $id)
    {
        return $this->drinkRepository->find($id);
    }

    /**
     * @param Drink $drink
     * @return bool
     */
    public function deleteDrink(Drink $drink): bool
    {
        return $this->drinkRepository->remove($drink);
    }

    /**
     * @param Drink $drink
     * @return Drink
     */
    public function updateDrink(Drink $drink)
    {
        return $this->drinkRepository->persist($drink);
    }
}
