<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

//use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $encoder, private EntityManagerInterface $em)
    {
    }

    public function load(\Doctrine\Persistence\ObjectManager $manager)
    {
        $usersData = [
            0 => [
                'email' => 'user@gmail.com',
                'role' => ['ROLE_USER'],
                'password' => 123456
            ],
            1 => [
                'email' => 'user2@gmail.com',
                'role' => ['ROLE_USER'],
                'password' => 123456
            ]
        ];

        foreach ($usersData as $user) {
            $newUser = new User();
            $newUser->setEmail($user['email']);
            $newUser->setPassword($this->encoder->hashPassword($newUser, $user['password']));
            $newUser->setRoles($user['role']);
            $this->em->persist($newUser);
        }

        $this->em->flush();
    }
}