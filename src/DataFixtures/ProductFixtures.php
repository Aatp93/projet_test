<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger)
    {
    }


    public function load(ObjectManager $manager): void
    {



        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 5; $i++) {


            $product = new Product();
            $product->setName($faker->text(10));
            $product->setDescription($faker->text(200));
            $product->setSlug($this->slugger->slug($product -> getName())->lower());
            $product->setPrix($faker->numberBetween(900, 15000));
            $product->setStock($faker->numberBetween(0, 10));

            $category = $this->getReference('cat-' . rand(1, 5));
            //$product->setCategorie($category);
            $manager->persist($product);
        }
        $manager->flush();
    }
}
