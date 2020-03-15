<?php

namespace App\Controller\Api;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/type")
 */
class TypeController extends BaseController
{
    /**
     * @Route("/", name="api_type_index", methods={"GET"})
     */
    public function index(TypeRepository $typeRepository): Response
    {
        return $this->respondWithSuccess('', $typeRepository->findAll());
    }

    /**
     * @Route("/new", name="api_type_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        $type = new Type();
        $form = $this->createForm(TypeType::class, $type);
        $data = $this->getInputFromRequest($request);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($type);
            $entityManager->flush();

            return $this->respondWithSuccess('Drink type added', [],Response::HTTP_CREATED);
        }

        return $this->respondWithError('Error', $this->getErrorsFromForm($form), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/{id}", name="api_type_show", methods={"GET"})
     */
    public function show(Type $type): Response
    {
        return $this->respondWithSuccess('', $type);
    }

    /**
     * @Route("/{id}/edit", name="api_type_edit", methods={"POST"})
     */
    public function edit(Request $request, Type $type): Response
    {
        $form = $this->createForm(TypeType::class, $type);
        $data = $this->getInputFromRequest($request);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->respondWithSuccess('Updated');
        }

        return $this->respondWithError('Error', $this->getErrorsFromForm($form), Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @Route("/{id}", name="api_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Type $type): Response
    {
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($type);
            $entityManager->flush();

            return $this->respondWithSuccess('Deleted');
        } catch (\Exception $exception) {
            //return $this->respondWithError($exception->getMessage());
            return $this->respondWithError('Something went wrong');
        }
    }
}
