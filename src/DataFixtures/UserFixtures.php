<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $encoder;

    function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->createUser("admin", $manager);
        $this->createUser("user", $manager);
    }

    private function createUser($type, $manager)
    {
        $user = new User();

        $upperType = strtoupper($type);

        $user
            ->setEmail("$type@$type.com")
            ->setRoles(["ROLE_$upperType"]);

        $hash = $this->encoder->hashPassword($user, $type);
        $user->setPassword($hash);

        $manager->persist($user);

        $manager->flush();
    }
}
