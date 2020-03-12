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
     * @return Response
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
     * @Route("/drink/create", name="drink-create")
     * @param Request $request
     * @return Response
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
     * @Route("/drink/{id}", name="drink-details")
     * @param int $id
     * @return Response
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
     * @Route("/drink/{id}/edit", name="drink-update")
     * @param Request $request
     * @param int $id
     * @return Response
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
     * @Route("/drink/{id}/delete", name="drink-delete")
     * @param int $id
     * @return Response
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
     * @param Request $request
     * @param Drink $drink
     * @return FormInterface
     */
    protected function getDrinkForm(Request $request, Drink $drink)
    {
        $form = $this->createForm(DrinkForm::class, $drink);

        $form->handleRequest($request);

        return $form;
    }
}
