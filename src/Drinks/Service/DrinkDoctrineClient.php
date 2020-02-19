<?php
declare(strict_types=1);

namespace App\Drinks\Service;


use App\Drinks\Exception\DrinkNotFoundException;
use App\Drinks\Exception\DrinkServiceUnavailableException;
use App\Entity\Drink;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;

class DrinkDoctrineClient implements DrinkService
{
	/** @var EntityManagerInterface  */
	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function findAll(): array
	{
		$entityArray = [];
		try {
			$entityArray = $this->entityManager->getRepository(Drink::class)->findAll();
		} catch (ORMException $e) {
			throw new DrinkServiceUnavailableException();
		}
		return $entityArray;
	}

	public function findById(int $id): Drink
	{
		try {
			$drink = $this->entityManager->getRepository(Drink::class)->find($id);
			if($drink === null) {
				throw new DrinkNotFoundException('Drink with ID'. $id. 'not found.');
			}
		} catch (ORMException $e) {
			throw new DrinkServiceUnavailableException();
		}
		return $drink;
	}

	public function create(Drink $drink): Drink
	{
		try {
			$this->entityManager->persist($drink);
			$this->entityManager->flush();
			return $drink;
		} catch (ORMException $e) {
			throw new DrinkServiceUnavailableException();
		}

	}

	public function update(Drink $drink): Drink
	{
		try {
			$updateableDrink = $this->entityManager->getRepository(Drink::class)->find($drink->getId());
			if ($updateableDrink === null) {
				throw new DrinkNotFoundException('Drink with ID'. $drink->getId(). 'not found. @developer Use create instead!');
			}
			$this->entityManager->persist($drink);
			$this->entityManager->flush();
			return $drink;
		} catch (ORMException $e) {
			throw new DrinkServiceUnavailableException();
		}
	}

	public function delete(int $id): void
	{
		try {
			$drink = $this->entityManager->getRepository(Drink::class)->find($id);

			if ($drink === null) {
				throw new DrinkNotFoundException('Drink with ID'. $id. 'not found.');
			}
			$this->entityManager->remove($drink);
			$this->entityManager->flush();
		} catch (ORMException $e) {
			throw new DrinkServiceUnavailableException();
		}
	}
}