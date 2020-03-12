<?php

namespace App\Controller\Web;

use App\Entity\Drink;
use App\Form\DrinkForm;
use App\Repository\DrinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DrinkController extends AbstractController
{
    /** @var DrinkRepository */
    private $drinkRepository;

    public function __construct(DrinkRepository $drinkRepository)
    {
        $this->drinkRepository = $drinkRepository;
    }

    /**
     * @Route("/", name="drink-list")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('drink/index.html.twig', [
            'drinks' => $this->drinkRepository->findAll(),
        ]);
    }

    /**
     * @Route("/drink/create", name="drink-create")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $drink = new Drink();

        $form = $this->createForm(DrinkForm::class, $drink);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->drinkRepository->persist($form->getData());

            return $this->redirectToRoute('drink-list');
        }

        return $this->render('drink/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/drink/{id}", name="drink-details")
     * @param Drink $drink
     * @return Response
     */
    public function show(Drink $drink): Response
    {
        return $this->render('drink/show.html.twig', [
            'drink' => $drink,
        ]);
    }

    /**
     * @Route("/drink/{id}/edit", name="drink-update")
     * @param Request $request
     * @param Drink $drink
     * @return Response
     */
    public function edit(Request $request, Drink $drink): Response
    {
        $form = $this->createForm(DrinkForm::class, $drink);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->drinkRepository->persist($form->getData());

            return $this->redirectToRoute('drink-list');
        }

        return $this->render('drink/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/drink/{id}/delete", name="drink-delete")
     * @param Drink $drink
     * @return Response
     */
    public function delete(Drink $drink): Response
    {
        $this->drinkRepository->remove($drink);

        return $this->redirectToRoute('drink-list');
    }
}
