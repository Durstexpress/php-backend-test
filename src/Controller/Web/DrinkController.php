<?php

namespace App\Controller\Web;

use App\Entity\Drink;
use App\Form\DrinkFormType;
use App\Service\DrinkService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DrinkController extends AbstractController
{
    /** @var DrinkService $drinkService */
    private $drinkService;

    /**
     * DrinkController constructor.
     * @param DrinkService $drinkService
     */
    public function __construct(DrinkService $drinkService)
    {
        $this->drinkService = $drinkService;
    }

    /**
     * @Route("/drink", name="web_drink_index")
     */
    public function index()
    {
        return $this->render('web/drink/index.html.twig', [
            'drinks' => $this->drinkService->getAllDrinks(),
        ]);
    }

    /**
     * @Route("/drink/create", name="web_drink_create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(Request $request)
    {
        $drink = new Drink();
        $form = $this->prepareDrinkForm($request, $drink);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->drinkService->createDrink($drink);
                $this->addFlash('success', 'Drink added.');

                return $this->redirectToRoute('web_drink_index');
            } catch (Exception $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('web/drink/form.html.twig', [
            'action_text' => 'Add A Drink',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/drink/{drink}", name="web_drink_show")
     * @param Drink $drink
     * @return RedirectResponse|Response
     */
    public function show(Drink $drink)
    {
        try {
            return $this->render('web/drink/show.html.twig', [
                'drink' => $this->drinkService->findDrinkById($drink->getId()),
            ]);
        } catch (Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
        }

        return $this->redirectToRoute('web_drink_index');
    }

    /**
     * @Route("/drink/{drink}/edit", name="web_drink_edit")
     * @param Request $request
     * @param Drink $drink
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, Drink $drink)
    {
        $form = $this->prepareDrinkForm($request, $drink);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->drinkService->updateDrink($drink);
                $this->addFlash('success', 'Drink updated.');

                return $this->redirectToRoute('web_drink_show', ['drink' => $drink->getId()]);
            } catch (Exception $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('web/drink/form.html.twig', [
            'action_text' => 'Edit The Drink',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/drink/{drink}/delete", name="web_drink_delete")
     * @param Drink $drink
     * @return RedirectResponse|Response
     */
    public function delete(Drink $drink)
    {
        try {
            $this->drinkService->deleteDrink($drink);
            $this->addFlash('success', 'Drink deleted.');
        } catch (Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
        }

        return $this->redirectToRoute('web_drink_index');
    }

    /**
     * @param Request $request
     * @param Drink $drink
     * @return FormInterface
     */
    private function prepareDrinkForm(Request $request, Drink $drink)
    {
        $form = $this->createForm(DrinkFormType::class, $drink);
        $form->handleRequest($request);

        return $form;
    }
}
