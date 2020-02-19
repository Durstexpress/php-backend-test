<?php
declare(strict_types=1);

namespace App\Drinks\Service;


use App\Drinks\Exception\DrinkNotFoundException;
use App\Drinks\Exception\DrinkServiceUnavailableException;
use App\Entity\Drink;

interface DrinkService
{
	/**
	 * @throws DrinkServiceUnavailableException
	 * @return Drink[]
	 */
	public function findAll(): array;

	/**
	 * @param int $id
	 * @throws DrinkNotFoundException
	 * @throws DrinkServiceUnavailableException
	 * @return Drink
	 */
	public function findById(int $id): Drink;

	/**
	 * @param Drink $drink
	 * @throws DrinkServiceUnavailableException
	 * @return Drink
	 */
	public function create(Drink $drink): Drink;

	/**
	 * @param Drink $drink
	 * @throws DrinkNotFoundException
	 * @throws DrinkServiceUnavailableException
	 * @return Drink
	 */
	public function update(Drink $drink): Drink;

	/**
	 * @param int $id
	 * @throws DrinkNotFoundException
	 * @throws DrinkServiceUnavailableException
	 * @return void
	 */
	public function delete(int $id): void;
}