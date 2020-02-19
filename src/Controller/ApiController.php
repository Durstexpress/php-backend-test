<?php

namespace App\Controller;

use App\Drinks\Exception\DrinkException;
use App\Drinks\Exception\DrinkNotFoundException;
use App\Drinks\Exception\DrinkServiceUnavailableException;
use App\Drinks\Service\DrinkService;
use App\Entity\Drink;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/v1/drink", name="api_drink_getlist", methods={"GET"})
     */
    public function getList(Request $request, DrinkService $drinksClient)
    {
    	$drinkJson = [];
		try {
			$drinks = $drinksClient->findAll();
		} catch (DrinkException $e) {
			return new Response('Internal Server Error', 500);
		}
		foreach ($drinks as $drink) {
			$drinkJson[] = [
				'id' => $drink->getId(),
				'name' => $drink->getName(),
				'type' => $drink->getType(),
				'price' => $drink->getPrice(),
				'bottle_deposit_price' => $drink->getBottleDepositPrice(),
				'contains_alcohol' => $drink->getContainsAlcohol(),
				'package' => $drink->getPackage()
			];
		}
		return $this->json($drinkJson);
    }

	/**
	 * @Route("/api/v1/drink/{id}", name="api_drink_get", requirements={"id"="\d+"}, methods={"GET"})
	 */
	public function getOne(DrinkService $drinksClient, int $id)
	{
		try {
			$drink = $drinksClient->findById($id);
		} catch (DrinkNotFoundException $e) {
			return new Response('Drink not found', 404);
		} catch (DrinkServiceUnavailableException $e) {
			return new Response('Internal Server Error', 500);
		}
		return $this->json([
			'id' => $drink->getId(),
			'name' => $drink->getName(),
			'type' => $drink->getType(),
			'price' => $drink->getPrice(),
			'bottle_deposit_price' => $drink->getBottleDepositPrice(),
			'contains_alcohol' => $drink->getContainsAlcohol(),
			'package' => $drink->getPackage()
		]);
	}

	/**
	 * @Route("/api/v1/drink/{id}", name="api_drink_add", requirements={"id"="\d+"}, methods={"POST"})
	 */
	public function post(Request $request, DrinkService $drinksClient, int $id)
	{
		$drinkArray = $request->request->get('body');
		//TODO create proper Entity
		$drink = new Drink();
		try {
			$drink = $drinksClient->create($drink);
		} catch (DrinkNotFoundException $e) {
			return new Response('Drink not found', 404);
		} catch (DrinkServiceUnavailableException $e) {
			return new Response('Internal Server Error', 500);
		}
		return new Response('',201);
	}

	/**
	 * @Route("/api/v1/drink/{id}", name="api_drink_update", requirements={"id"="\d+"}, methods={"PUT"})
	 */
	public function put(Request $request, DrinkService $drinksClient, int $id)
	{
		$drinkArray = $request->request->get('body');
		//TODO create proper Entity
		$drink = new Drink();
		try {
			$drink = $drinksClient->update($drink);
		} catch (DrinkNotFoundException $e) {
			return new Response('Drink not found', 404);
		} catch (DrinkServiceUnavailableException $e) {
			return new Response('Internal Server Error', 500);
		}
		return new Response('',201);
	}

	/**
	 * @Route("/api/v1/drink/{id}", name="api_drink_delete", requirements={"id"="\d+"}, methods={"DELETE"})
	 */
	public function delete(Request $request, DrinkService $drinksClient, int $id)
	{
		try {
			$drinksClient->delete($id);
		} catch (DrinkNotFoundException $e) {
			return new Response('Drink not found', 404);
		} catch (DrinkServiceUnavailableException $e) {
			return new Response('Internal Server Error', 500);
		}
		return new Response('',200);
	}
}
