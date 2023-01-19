<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    private $slugger;

    public function __construct(UserPasswordHasherInterface $passwordEncoder, SluggerInterface $slugger)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->slugger = $slugger;
    }



    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@dwwm.fr');
        $admin->setLastname('Toto');
        $admin->setFirstName('Tata');
        $admin->setAdress('12 rue toto');
        $admin->setZipcode('14000');
        $admin->setCity('Caen');
        $admin->setPassword($this->passwordEncoder->hashPassword($admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $faker = Faker\Factory::create('fr_FR');

        for ( $i= 1; $i <= 5; $i++) {


            $client = new User();
            $client->setEmail($faker->email);
            $client->setLastname($faker->lastname);
            $client->setFirstName($faker->firstname);
            $client->setAdress($faker->streetAddress);
            $client->setZipcode(str_replace('','',$faker->postcode));
            $client->setCity($faker->city);
            $client->setPassword(
                $this->passwordEncoder->hashPassword($client, 'secret'));
        
            $client->setRoles(['ROLE_CLIENT']);
            $manager ->persist($client);
        };
        $manager->flush();
    }
}
