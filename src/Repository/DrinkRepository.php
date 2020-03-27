<?php

namespace App\Repository;

use App\Entity\Drink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Drink|null find($id, $lockMode = null, $lockVersion = null)
 * @method Drink|null findOneBy(array $criteria, array $orderBy = null)
 * @method Drink[]    findAll()
 * @method Drink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DrinkRepository extends ServiceEntityRepository
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * DrinkRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->entityManager = $registry->getManagerForClass(Drink::class);

        parent::__construct($registry, Drink::class);
    }

    /**
     * @param Drink $drink
     * @return Drink
     */
    public function persist(Drink $drink): Drink
    {
        $this->entityManager->persist($drink);
        $this->entityManager->flush();

        return $drink;
    }

    /**
     * @param Drink $drink
     * @return bool
     */
    public function remove(Drink $drink)
    {
        $this->entityManager->remove($drink);
        $this->entityManager->flush();

        return true;
    }
}
