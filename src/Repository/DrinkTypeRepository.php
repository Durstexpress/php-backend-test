<?php

namespace App\Repository;

use App\Entity\DrinkType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method DrinkType|null find($id, $lockMode = null, $lockVersion = null)
 * @method DrinkType|null findOneBy(array $criteria, array $orderBy = null)
 * @method DrinkType[]    findAll()
 * @method DrinkType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DrinkTypeRepository extends ServiceEntityRepository
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * DrinkTypeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->entityManager = $registry->getManagerForClass(DrinkType::class);

        parent::__construct($registry, DrinkType::class);
    }

    /**
     * @param DrinkType $drinkType
     * @return DrinkType
     */
    public function persist(DrinkType $drinkType): DrinkType
    {
        $this->entityManager->persist($drinkType);
        $this->entityManager->flush();

        return $drinkType;
    }

    /**
     * @param DrinkType $drinkType
     * @return bool
     */
    public function remove(DrinkType $drinkType)
    {
        $this->entityManager->remove($drinkType);
        $this->entityManager->flush();

        return true;
    }
}
