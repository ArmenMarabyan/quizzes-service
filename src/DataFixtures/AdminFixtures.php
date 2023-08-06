<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $encoder, private EntityManagerInterface $em)
    {
    }

    public function load(\Doctrine\Persistence\ObjectManager $manager)
    {
        $adminsData = [
            0 => [
                'email' => 'admin@gmail.com',
                'role' => ['ROLE_ADMIN'],
                'password' => 123456
            ]
        ];

        foreach ($adminsData as $admin) {
            $newAdmin = new Admin();
            $newAdmin->setEmail($admin['email']);
            $newAdmin->setPassword($this->encoder->hashPassword($newAdmin, $admin['password']));
            $newAdmin->setRoles($admin['role']);
            $this->em->persist($newAdmin);
        }

        $this->em->flush();
    }
}