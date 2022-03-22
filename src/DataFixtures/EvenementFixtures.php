<?php

namespace App\DataFixtures;

use DateTime;
use Faker;
use App\Entity\Evenement;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EvenementFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i < 100; $i++) {
            $evenement = new Evenement();
            // $evenement->setStart(new DateTime());
            $evenement->setStart(new DateTime("2022-03-" . (($i + rand(1, 5)) % 28))); // de dates pour mars 2022
            // $evenement->setEnd(new DateTime());
            $evenement->setTitle($faker->word);
            $evenement->setDescription($faker->word . " " . $faker->word . " " . $faker->word);
            // Array Bool pour pourvoir faire du aléatoire pour la fixture
            $arrAllDay = [true,false];
            $evenement->setAllDay($arrAllDay[rand(0,1)]);
            // Array de Couleurs pour pourvoir faire du aléatoire pour la fixture
            $colors = ["#FFAABB","#EEFFAA","BBAA33"];
            $evenement->setBackgroundColor($colors[rand(0,2)]);
            // $evenement->setTextColor($colors [rand(0,2)]);
            // $evenement->setBorderColor($colors [rand(0,2)]);
            
            $manager->persist($evenement);
        }
        
        $manager->flush();
    }
}
