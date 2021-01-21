<?php

namespace App\DataFixtures;

use App\Entity\TypeActivity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeActivityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /**
         *  On créé les 3grands groupes d'activités
         */

        $typeactivity = new TypeActivity();
        $typeactivity->setName('Publication');
        $manager->persist($typeactivity);

        $typeactivity = new TypeActivity();
        $typeactivity->setName('Évènement');
        $manager->persist($typeactivity);

        $typeactivity = new TypeActivity();
        $typeactivity->setName('Projet');
        $manager->persist($typeactivity);

        $typeactivity = new TypeActivity();
        $typeactivity->setName('Autre');
        $manager->persist($typeactivity);


        $manager->flush();
    }
}
