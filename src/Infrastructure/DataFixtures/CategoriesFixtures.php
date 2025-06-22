<?php

namespace App\DataFixtures;

use App\Entity\Blog\Categories;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoriesFixtures extends Fixture
{
    private $counter = 1;

    public function load(ObjectManager $manager): void
    {

        $this->createCategories('Recette salée', $manager);
        $this->createCategories('Recette sucrée', $manager);
        $this->createCategories('Article', $manager);

        
        $manager->flush();
    }

    public function createCategories(String $name, ObjectManager $manager){

        $category = new Categories();
        $category->setName($name);
        $category->setSlug($category->getName());

        $manager->persist($category);

        $this->addReference('cat-'. $this->counter, $category);
        $this->counter++;

        return $category;


    }
}