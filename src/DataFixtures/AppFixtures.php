<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $User = new User();
        $User->setUsername("akram");
        $password = $this->hasher->hashPassword($User,"1234");
        $User->setPassword($password);
        $manager->persist($User);

        $manager->flush();
        //💡 : use this command to execute this code and create data in database :
        //utilisateur existant : `symfony console doctrine:fixtures:load --append`
        // ndc : admin , mdp : admin
        // mdc : akram , mdp : 1234
    }
}
