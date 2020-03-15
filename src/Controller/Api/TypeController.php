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
     * @param TypeRepository $typeRepository
     * @return Response
     */
    public function index(TypeRepository $typeRepository): Response
    {
        return $this->respondWithSuccess('', $typeRepository->findAll());
    }

    /**
     * @Route("/new", name="api_type_new", methods={"POST"})
     * @param Request $request
     * @return Response
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
     * @param TypeRepository $typeRepository
     * @param $id
     * @return Response
     */
    public function show(TypeRepository $typeRepository, $id): Response
    {
        $type = $typeRepository->find($id);
        if (!$type)
            return $this->respondWithError('Not found', [], Response::HTTP_NOT_FOUND);
        return $this->respondWithSuccess('', $type);
    }

    /**
     * @Route("/{id}/edit", name="api_type_edit", methods={"POST"})
     * @param Request $request
     * @param TypeRepository $typeRepository
     * @param $id
     * @return Response
     */
    public function edit(Request $request, TypeRepository $typeRepository, $id): Response
    {
        $type = $typeRepository->find($id);
        if (!$type)
            return $this->respondWithError('Not found', [], Response::HTTP_NOT_FOUND);
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
     * @param TypeRepository $typeRepository
     * @param $id
     * @return Response
     */
    public function delete(TypeRepository $typeRepository, $id): Response
    {
        $type = $typeRepository->find($id);
        if (!$type)
            return $this->respondWithError('Not found', [], Response::HTTP_NOT_FOUND);

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
