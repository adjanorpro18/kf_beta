<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /**
         *  On créé les 10 categories d'activités
         */

        $category = new Category();
        $category->setName('Arts & Culture');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Cuisine');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Sciences');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Jeux');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Loisirs');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Vivre ensemble');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Environnement');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Sorties éducatives');
        $manager->persist($category);

        $category = new Category();
        $category->setName('DIY');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Autres');
        $manager->persist($category);


        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            TypeActivityFixtures::class,
            PicturesFixtures::class,

        );

    }
}
