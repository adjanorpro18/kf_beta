<?php

namespace App\DataFixtures;

use App\Entity\Publics;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PublicsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /**
         *  On créé les 5 groupes de publics
         */

        $publics = new Publics();
        $publics ->setName('Bébé');
        $manager->persist($publics );

        $publics = new Publics();
        $publics ->setName('Enfants');
        $manager->persist($publics );

        $publics = new Publics();
        $publics ->setName('adolescents');
        $manager->persist($publics );

        $publics = new Publics();
        $publics ->setName('adultes');
        $manager->persist($publics );

        $publics = new Publics();
        $publics ->setName('seniors');
        $manager->persist($publics );

        $publics = new Publics();
        $publics ->setName('famille');
        $manager->persist($publics );


        $manager->flush();
    }
}
