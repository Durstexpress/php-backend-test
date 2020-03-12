<?php

namespace App\Repository;

use App\Entity\DrinkType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DrinkType|null find($id, $lockMode = null, $lockVersion = null)
 * @method DrinkType|null findOneBy(array $criteria, array $orderBy = null)
 * @method DrinkType[]    findAll()
 * @method DrinkType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DrinkTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DrinkType::class);
    }
}
