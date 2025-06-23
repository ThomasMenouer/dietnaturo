<?php

namespace App\Infrastructure\DataFixtures;


use Faker;
use App\Domain\Blog\Entity\Articles;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class ArticlesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create();

        for ($i=0; $i < 20; $i++) { 
        
            $article = new Articles();

            $article->setTitle($faker->words(3, true));
            $article->setContent($faker->text());
            
            $category = $this->getReference('cat-'. rand(1, 3), "category");
            $article->setCategories($category);

            $article->setDatePublished($faker->datetime());
            $article->setSlug($article->getTitle());

            $manager->persist($article);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoriesFixtures::class,
        ];
    }
}
