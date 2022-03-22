<?php

namespace App\DataFixtures;

use App\Entity\Evenement;
use App\Entity\Utilisateur;
use App\DataFixtures\EvenementFixtures;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\UtilisateurFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UtilisateursEvenementLienFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // on obtient tous les utilisateurs. Pour chaque Evenement on fixera un User random
        $rep = $manager->getRepository(Utilisateur::class);
        $utilisateurs = $rep->findAll(); // array d'utilisateurs

        $rep = $manager->getRepository(Evenement::class);
        $evenements = $rep->findAll(); // array d'événements

        // créer des Evenements
        for ($i = 0; $i < count($evenements); $i++) {
            // affecter un utilisateur random
            $utilisateurChoisi = $utilisateurs[rand(0,count($utilisateurs)-1)];
            $utilisateurChoisi->addEvenement($evenements[$i]);

            $manager->persist($evenements[$i]);
        }
        $manager->flush();
    }

    // Pour préciser qu'il faut d'abord faire les Fixtures de Catégories et User avant Inscription
    // implements DependentFixtureInterface en haut pour la classe et ajouter ici dépendances.
    // Ne pas oublier d'importer les CLASS (clic droit pour obtenir use)
    public function getDependencies()
    {
        return([
            UtilisateurFixtures::class,
            EvenementFixtures::class
        ]);
    }
}
