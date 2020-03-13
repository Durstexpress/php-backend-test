<?php

namespace App\Service;

use App\Entity\Drink;
use Exception;

interface DrinkServiceInterface
{
    /**
     * @return Drink[]
     *
     * @throws Exception
     */
    public function getAllDrinks(): array;

    /**
     * @throws Exception
     */
    public function getDrinkById(int $drinkId): Drink;

    /**
     * @throws Exception
     */
    public function createDrink(Drink $drink): Drink;

    /**
     * @throws Exception
     */
    public function updateDrink(Drink $drink): Drink;

    /**
     * @throws Exception
     */
    public function deleteDrinkById(int $drinkId): void;
}
