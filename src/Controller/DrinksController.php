<?php
declare(strict_types=1);

namespace App\Controller;

use App\Drinks\Exception\DrinkException;
use App\Drinks\Service\DrinkService;
use App\Entity\Drink;
use App\Form\DrinksType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DrinksController extends AbstractController
{
    /**
     * @Route("/drinks", name="drinks")
     */
    public function index(DrinkService $drinksClient)
	{
		$drinks = [];
		try {
			$drinks = $drinksClient->findAll();
		} catch (DrinkException $e) {
			return $this->render('drinks/index.html.twig', [
				'drinks' => $drinks,
				'error' => true
			]);
		}
		return $this->render('drinks/index.html.twig', [
            'drinks' => $drinks,
			'error' => false
        ]);
    }

	/**
	 * @Route("/drinks/add", name="add_drinks")
	 */
	public function add(Request $request, DrinkService $drinksClient)
	{
		$drink = new Drink();
		$form = $this->createForm(DrinksType::class, $drink);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$drink = $form->getData();
			try {
				$drinksClient->create($drink);
			} catch (DrinkException $e) {
				return $this->render('drinks/add.html.twig', [
					'form' => $form->createView(),
					'error' => true
				]);
			}
			return $this->redirectToRoute('drinks');
		}
		return $this->render('drinks/add.html.twig', [
			'form' => $form->createView(),
			'error' => false
		]);
	}

	/**
	 * @Route("/drinks/edit/{id}", name="edit_drinks", requirements={"id"="\d+"})
	 */
	public function edit(Request$request, DrinkService $drinksClient, int $id)
	{
		$drink = $this->getDoctrine()->getRepository(Drink::class)->find($id);
		if (!$drink) {
			return $this->redirectToRoute('drinks');
		}
		$form = $this->createForm(DrinksType::class, $drink);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$drink = $form->getData();
			try {
				$drinksClient->update($drink);
			} catch (DrinkException $e) {
				return $this->render('drinks/edit.html.twig', [
					'form' => $form->createView(),
					'error' => true
				]);
			}
			return $this->redirectToRoute('drinks');
		}

		return $this->render('drinks/edit.html.twig', [
			'form' => $form->createView(),
			'error' => false
		]);
	}

	/**
	 * @Route("/drinks/delete", name="do_delete_drinks")
	 */
	public function delete(Request $request, DrinkService $drinksClient)
	{
		if(!$request->isXmlHttpRequest()) {
			return $this->redirectToRoute('drinks');
		}
		$id = $request->request->get('id', 0);
		/** @var DrinkService $drinksClient */
		#$drinksClient = $this->get('drinks.doctrine');
		try {
			$drinksClient->delete($id);
		} catch (DrinkException $e) {
			return $this->json(['message' => 'error']);
		}
		return $this->json(['message' => 'success']);
	}

}
