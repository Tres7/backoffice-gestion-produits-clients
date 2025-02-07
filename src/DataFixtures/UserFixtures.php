<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
//        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail('Daniel.gaboucado@gmail.com');
        $user1->setFirstName('Daniel');
        $user1->setLastName('Gaboucado');
        $user1->setRoles(['ROLE_USER']);
        $user1->setPassword($this->passwordHasher->hashPassword($user1,'password1'));
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('ouiza.kaddour487@hotmail.com');
        $user2->setFirstName('Ouiza');
        $user2->setLastName('KADDOUR');
        $user2->setRoles(['ROLE_ADMIN']);
        $user2->setPassword($this->passwordHasher->hashPassword($user2,'password2'));
        $manager->persist($user2);

        $user3 = new User();
        $user3->setEmail('richard.bureau@gmail.com');
        $user3->setFirstName('Richard');
        $user3->setLastName('Bureau');
        $user3->setRoles(['ROLE_MANAGER']);
        $user3->setPassword($this->passwordHasher->hashPassword($user3,'password3'));
        $manager->persist($user3);

        $user4 = new User();
        $user4->setEmail('christian.ilaneige@gmail.com');
        $user4->setFirstName('Christian');
        $user4->setLastName('Ilaneige');
        $user4->setRoles(['ROLE_USER']);
        $user4->setPassword($this->passwordHasher->hashPassword($user4,'password4'));
        $manager->persist($user4);

        $user5 = new User();
        $user5->setEmail('david.malade@gmail.com');
        $user5->setFirstName('David');
        $user5->setLastName('Malade');
        $user5->setRoles(['ROLE_ADMIN']);
        $user5->setPassword($this->passwordHasher->hashPassword($user5,'password5'));
        $manager->persist($user5);

        $user6 = new User();
        $user6->setEmail('tarik.duvillage@gmail.com');
        $user6->setFirstName('Tarik');
        $user6->setLastName('Duvillage');
        $user6->setRoles(['ROLE_MANAGER']);
        $user6->setPassword($this->passwordHasher->hashPassword($user6,'password6'));
        $manager->persist($user6);

        $manager->flush();
    }
}
