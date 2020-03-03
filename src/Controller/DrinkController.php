<?php

namespace App\Controller;

use App\Entity\Drink;
use App\Form\DrinkType;
use App\Repository\DrinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/drink", name="drink_") */
class DrinkController extends AbstractController
{
    /** @var DrinkRepository */
    private $drinkRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(DrinkRepository $drinkRepository, EntityManagerInterface $entityManager)
    {
        $this->drinkRepository = $drinkRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/index", name="index")
     */
    public function index(): Response
    {
        return $this->render('drink/index.html.twig', [
            'drinks' => $this->drinkRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request): Response
    {
        $drink = new Drink();

        $form = $this->createForm(DrinkType::class, $drink);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $drink = $form->getData();
            $this->entityManager->persist($drink);
            $this->entityManager->flush();

            return $this->redirectToRoute('drink_index');
        }

        return $this->render('drink/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Drink $drink): Response
    {
        return $this->render('drink/show.html.twig', [
            'drink' => $drink,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request, Drink $drink): Response
    {
        $form = $this->createForm(DrinkType::class, $drink);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $drink = $form->getData();
            $this->entityManager->persist($drink);
            $this->entityManager->flush();

            return $this->redirectToRoute('drink_index');
        }

        return $this->render('drink/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Drink $drink): Response
    {
        $this->entityManager->remove($drink);
        $this->entityManager->flush();

        return $this->redirectToRoute('drink_index');
    }
}
