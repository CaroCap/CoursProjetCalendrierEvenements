<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurFixtures extends Fixture
{
    // injection de dépendance dans l'objet de construction pour le Password
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
         $this->passwordHasher = $passwordHasher;
    }

    
    public function load(ObjectManager $manager): void
    {
        // on va créer 3 admins et 3 clients+gestionnaires
        // sachez qu'ils auront par défaut aussi le ROLE_USER
        for ($i = 0; $i < 3 ; $i++){
            $user = new Utilisateur();
            $user->setEmail ("newuser".$i."@lala.com"); // user1@lala.com, user2@lala.com etc....
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                'lePassword'.$i // lepassword1, lepassword2, etc...
            ));
            $user->setNom("nom".$i);
            $user->setPrenom("prenom".$i);
            $user->setRoles(['ROLE_GESTIONNAIRE']);
            $manager->persist ($user);
        }
        for ($i = 0; $i < 3 ; $i++){
            $user = new Utilisateur();
            $user->setEmail ("autreuser".$i."@lala.com"); // user1@lala.com, user2@lala.com etc....
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                'lePassword'.$i // lepassword1, lepassword2, etc...
            ));
            $user->setNom("nom".$i);
            $user->setPrenom("prenom".$i);
            $user->setRoles(['ROLE_CLIENT']);
            $manager->persist ($user);
        }
        $manager->flush();
    }
}
