<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use App\Entity\Client;
use App\Entity\Produit;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
     

      public function load(ObjectManager $manager)
      {
            $faker = Faker\Factory::create('fr_FR');
            $produit = [];
            $user = new User();
      
            for ($i = 0; $i < 50; $i++) {
                  $produit[$i] = new Produit();
                  $produit[$i]->setPrixUHT(mt_rand(10, 100));
                  $produit[$i]->setPrixUTTC(mt_rand(10, 100));
                  $produit[$i]->setNomProduit($faker->word());
                 
                  $manager->persist($produit[$i]);
            }
            $clients = [];
            for ($i = 0; $i < 50; $i++) {
                  $clients[$i] = new Client;
                  $clients[$i]->setNomClient($faker->firstName);
                  $clients[$i]->setPrenomClient($faker->lastName);
                  $clients[$i]->setTel($faker->phoneNumber);
                   $clients[$i]->setFixe($faker->phoneNumber);
                  $clients[$i]->setEmail($faker->email);
                  $clients[$i]->setCodePostalClient($faker->postcode);
                  $clients[$i]->setVilleClient($faker->city);
                  $clients[$i]->setNomRueClient($faker->streetName);
                  $clients[$i]->setNumRueClient(random_int(10, 20));
                  $clients[$i]->setAdresseFactureClient($faker->address);
                  $clients[$i]->setNumeroDeSerieClient(mt_rand(1, 10));
                  $clients[$i]->setPaysClient($faker->country);
                  $clients[$i]->setNomSociete($faker->company);
                  $clients[$i]->setTitreEntrepriseClient($faker->title());
                  $clients[$i]->setCoditionDePaiement("15");

                  $manager->persist($clients[$i]);
            }

            $manager->flush();
      }
}