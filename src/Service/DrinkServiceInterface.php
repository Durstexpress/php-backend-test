<?php


namespace App\Service;


use App\Entity\Drink;
use App\Exception\AppException;
use App\Exception\NotFoundException;
use Exception;

interface DrinkServiceInterface
{

    /**
     * @return Drink[]
     * @throws AppException
     */
    public function getAllDrinks(): array;

    /**
     * @param int $drinkId
     * @return Drink
     * @throws Exception
     */
    public function getDrinkById(int $drinkId): Drink;

    /**
     * @param Drink $drink
     * @return Drink
     * @throws Exception
     */
    public function createDrink(Drink $drink): Drink;

    /**
     * @param Drink $drink
     * @return Drink
     * @throws Exception
     */
    public function updateDrink(Drink $drink): Drink;

    /**
     * @param int $drinkId
     * @return void
     * @throws Exception
     */
    public function deleteDrinkById(int $drinkId): void;
}
