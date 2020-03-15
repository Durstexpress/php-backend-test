<?php

namespace App\Controller\Api;

use App\Entity\Drink;
use App\Form\DrinkType;
use App\Repository\DrinkRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/drink")
 */
class DrinkController extends BaseController
{
    /**
     * @Route("/", name="api_drink_index", methods={"GET"})
     */
    public function index(DrinkRepository $drinkRepository): Response
    {
        return $this->respondWithSuccess('', $drinkRepository->findAll());
    }

    /**
     * @Route("/new", name="api_drink_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        $drink = new Drink();
        $form = $this->createForm(DrinkType::class, $drink);
        $data = $this->getInputFromRequest($request);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($drink);
            $entityManager->flush();

            return $this->respondWithSuccess('Drink added', [],Response::HTTP_CREATED);
        }

        return $this->json($this->getErrorsFromForm($form), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/{id}", name="api_drink_show", methods={"GET"})
     */
    public function show(Drink $drink): Response
    {
        return $this->respondWithSuccess('', $drink);
    }

    /**
     * @Route("/{id}/edit", name="api_drink_edit", methods={"POST"})
     */
    public function edit(Request $request, Drink $drink): Response
    {
        $form = $this->createForm(DrinkType::class, $drink);
        $data = $this->getInputFromRequest($request);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->respondWithSuccess('Updated');
        }

        return $this->respondWithError('Error', $this->getErrorsFromForm($form), Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @Route("/{id}", name="api_drink_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Drink $drink): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($drink);
        $entityManager->flush();

        return $this->respondWithSuccess('Deleted');
    }
}
