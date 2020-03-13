<?php

namespace App\Controller\Web;

use App\Entity\Drink;
use App\Form\DrinkForm;
use App\Service\DrinkService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DrinkController.
 */
class DrinkController extends AbstractController
{
    /** @var DrinkService */
    private $drinkService;

    public function __construct(DrinkService $drinkService)
    {
        $this->drinkService = $drinkService;
    }

    /**
     * @Route("/", name="drink-list")
     */
    public function index(): Response
    {
        $drinks = [];

        try {
            $drinks = $this->drinkService->getAllDrinks();
        } catch (\Exception $e) {
            // Flash message
        }

        return $this->render('drink/index.html.twig', [
            'drinks' => $drinks,
        ]);
    }

    /**
     * @Route("/drinks/create", name="drink-create")
     */
    public function add(Request $request): Response
    {
        $form = $this->getDrinkForm($request, new Drink());

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->drinkService->createDrink($form->getData());

                return $this->redirectToRoute('drink-list');
            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('drink/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/drinks/{id}", name="drink-details")
     */
    public function show(int $id): Response
    {
        try {
            return $this->render('drink/show.html.twig', [
                'drink' => $this->drinkService->getDrinkById($id),
            ]);
        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('drink-list');
    }

    /**
     * @Route("/drinks/{id}/edit", name="drink-update")
     */
    public function edit(Request $request, int $id): Response
    {
        try {
            $form = $this->getDrinkForm(
                $request,
                $this->drinkService->getDrinkById($id)
            );

            if ($form->isSubmitted() && $form->isValid()) {
                $this->drinkService->updateDrink($form->getData());
            } else {
                return $this->render('drink/edit.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('drink-list');
    }

    /**
     * @Route("/drinks/{id}/delete", name="drink-delete")
     */
    public function delete(int $id): Response
    {
        try {
            $this->drinkService->deleteDrinkById($id);
        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('drink-list');
    }

    /**
     * @return FormInterface
     */
    protected function getDrinkForm(Request $request, Drink $drink)
    {
        $form = $this->createForm(DrinkForm::class, $drink);

        $form->handleRequest($request);

        return $form;
    }
}
