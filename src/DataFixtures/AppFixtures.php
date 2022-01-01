<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->passwordEncoder = $passwordEncoder;

    }

    public function load(ObjectManager $manager)
    {
        $roles = [
            'ROLE_USER',
            'ROLE_HR',
            'ROLE_RESPONSABLE',
            'ROLE_ADMIN'
        ];

        for ($i = 0; $i < 4; $i++) {
            $user = new User();
            $user->setFirstName("name $i");
            $user->setLastName("lastname $i");
            $user->setEmail("local$i@test.com");
			$user->setType([]);
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    '123'
                )
            );

            $user->setRoles([$roles[$i]]);
            $manager->persist($user);

        }
        $manager->flush();
    }


}
