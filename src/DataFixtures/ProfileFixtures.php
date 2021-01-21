<?php

namespace App\DataFixtures;


use App\Entity\Profile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfileFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /**
         *  On créé les 2 groupes de profil
         */

        $profile = new Profile();
        $profile->setName('Particulier');
        $manager->persist($profile);

        $profile = new Profile();
        $profile->setName('Professionnel');
        $manager->persist($profile);

        $manager->flush();
    }
}
