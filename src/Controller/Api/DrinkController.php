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
     * @param DrinkRepository $drinkRepository
     * @return Response
     */
    public function index(DrinkRepository $drinkRepository): Response
    {
        return $this->respondWithSuccess('', $drinkRepository->findAll());
    }

    /**
     * @Route("/new", name="api_drink_new", methods={"POST"})
     * @param Request $request
     * @return Response
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

        return $this->respondWithError('Error', $this->getErrorsFromForm($form), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/{id}", name="api_drink_show", methods={"GET"})
     * @param DrinkRepository $drinkRepository
     * @param $id
     * @return Response
     */
    public function show(DrinkRepository $drinkRepository, $id): Response
    {
        $drink = $drinkRepository->find($id);
        if (!$drink)
            return $this->respondWithError('Not found', [], Response::HTTP_NOT_FOUND);
        return $this->respondWithSuccess('', $drink);
    }

    /**
     * @Route("/{id}/edit", name="api_drink_edit", methods={"POST"})
     * @param Request $request
     * @param DrinkRepository $drinkRepository
     * @param $id
     * @return Response
     */
    public function edit(Request $request, DrinkRepository $drinkRepository, $id): Response
    {
        $drink = $drinkRepository->find($id);
        if (!$drink)
            return $this->respondWithError('Not found', [], Response::HTTP_NOT_FOUND);
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
     * @param DrinkRepository $drinkRepository
     * @param $id
     * @return Response
     */
    public function delete(DrinkRepository $drinkRepository, $id): Response
    {
        $drink = $drinkRepository->find($id);
        if (!$drink)
            return $this->respondWithError('Not found', [], Response::HTTP_NOT_FOUND);

        try {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($drink);
            $entityManager->flush();

            return $this->respondWithSuccess('Deleted');
        } catch (\Exception $exception) {
            //return $this->respondWithError($exception->getMessage());
            return $this->respondWithError('Something went wrong');
        }
    }
}
