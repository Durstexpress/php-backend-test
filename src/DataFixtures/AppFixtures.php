<?php

namespace App\DataFixtures;

use App\Entity\DrinkType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $drinkTypes = [
            'Water',
            'Juice',
            'Soda',
            'Beer',
            'Wine',
            'Spirits'
        ];

        foreach ($drinkTypes as $drinkType) {
            $entity = new DrinkType();
            $entity->setName($drinkType);
            $manager->persist($entity);
        }

        $manager->flush();
    }
}
