<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categorie;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategorieFixtures extends Fixture
{
    private int $counter = 1; 

    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void{
    
    //     $parent = new Categorie();
    //     $parent->setName('Informatique');
    //     $parent->setSlug($this->slugger->slug($parent->getName())->lower());
    //     $manager->persist($parent);

    //     $category = new Categorie();
    //     $category->setName('Ordinateurs portable');
    //     $category->setSlug($this->slugger->slug($category->getName())->lower());
    //     $category->setParent($parent);
    //     $manager->persist($category);

    //     $category = new Categorie();
    //     $category->setName('Ecran');
    //     $category->setSlug($this->slugger->slug($category->getName())->lower());
    //     $category->setParent($parent);
    //     $manager->persist($category);
        
    // $parent = $this->createCategorie( name :'Informatique', manager: $manager);
        $parent = $this->createCategorie('Informatique', null, $manager);
        $this->createCategorie('Ecran', $parent, $manager);
        $this->createCategorie('Ordinateur portable', $parent, $manager);
        $this->createCategorie('Clavier', $parent, $manager);
        // $this->createCategorie('Téléphone', null, $manager);
        $this->createCategorie('Téléphone', null, $manager);
        $manager->flush();
    }

    public function createCategorie(string $name, Categorie $parent = null, ObjectManager $manager)
    {

        $category = new Categorie();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $manager->persist($category);

        $this->addReference('cat-'. $this->counter, $category);
        $this->counter++; 

        return $category; 
    }
}
