<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $roleUser = new Role();
        $roleUser->setRole('ROLE_USER');
        $manager->persist($roleUser);

        $roleAdmin = new Role();
        $roleAdmin->setRole('ROLE_ADMIN');
        $manager->persist($roleAdmin);

        $user = new User();
        $user->setLogin('yuyu');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordHasher->hashPassword($user,'yuuyuu'));
        $user->setFirstName('Yusrâ');
        $user->setLastName('Arigui');
        $user->setEmail('yuyuari@yuuuyu.com');
        $user->setRole($roleUser);
        $user->setLangue('FR');

        $manager->persist($user);

        $manager->flush();
    }
}
