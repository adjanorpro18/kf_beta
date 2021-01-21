<?php

namespace App\DataFixtures;

use App\Entity\State;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StateFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $state = new State();
        $state ->setName('En cours');
        $manager->persist($state );

        $state = new State();
        $state ->setName('Publiée');
        $manager->persist($state );

        $state = new State();
        $state ->setName('Terminée');
        $manager->persist($state );




        $manager->flush();
    }
}
