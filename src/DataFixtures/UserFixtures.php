<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;


    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;

    }
    public function load(ObjectManager $manager)
    {
        //Administarteur

        $userAdmin = new User();
        $userAdmin->setEmail('admin@kids-family.com');
        $userAdmin->setPseudo('administrateur');
        $userAdmin->setPassword($this->encoder->encodePassword($userAdmin, 'kidsfamily'));
        $userAdmin->setRoles(['ROLE_ADMIN']);

        $manager->persist($userAdmin);

        //Ambassadeur

        $userAmbassadeur = new User();
        $userAmbassadeur->setEmail('ambassadeur@kids-family.com');
        $userAmbassadeur->setPseudo('ambassadeur');
        $userAmbassadeur->setPassword($this->encoder->encodePassword($userAmbassadeur, 'kidsfamily'));
        $userAmbassadeur->setRoles(['ROLE_AMBASSADEUR']);

        $manager->persist($userAmbassadeur);

        //Visiteur

        $userVisiteur = new User();
        $userVisiteur->setEmail('visiteur@kids-family.com');
        $userVisiteur->setPseudo('visiteur');
        $userVisiteur->setPassword($this->encoder->encodePassword($userVisiteur, 'kidsfamily'));
        $userVisiteur->setRoles(['ROLE_VISITEUR']);

        $manager->persist($userVisiteur);


        $manager->flush();
    }
}
