<?php

namespace App\DataFixtures;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setNickname('user');
        $user->setEmail('aurelienwalter@orange.fr');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'test'
        ));
        // $product = new Product();
        $manager->persist($user);

        $manager->flush();
    }
}
