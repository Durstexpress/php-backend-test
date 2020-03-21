<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class GenericService
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    private $entity;

    /**
     * DrinkService constructor.
     *
     * @param $entity
     */
    public function __construct(EntityManagerInterface $entityManager, $entity)
    {
        $this->entityManager = $entityManager;
        $this->entity = $entity;
    }

    protected function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository($this->entity);
    }
}
