<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        // // Créer un customer admin
        // $customer = new Customer();
        // $customer->setEmail('aurelienwalter@orange.fr');
        // $customer->setUsername('bichuci');
        // $customer->setRoles(['ROLE_ADMIN']);

        // //On génére le hash du mot de passe test 
        // $encodedPassword = $this->passwordEncoder->encodePassword($customer, 'test');
        // $customer->setPassword($encodedPassword);
        // $manager->persist($customer);



        // // Créer les utilisateurs
        // $users = []; // Le tableau va nous aider à stocker les instances des user
        // for ($i = 0; $i < 10; $i++) {
        //     $user = new User();
        //     $user->setUsername('Username '.$i);
        //     $manager->persist($user);
        //     $users[] = $user; // On met l'instance de côté
        // }
        // $product = new Product();
        // $manager->persist($product);
       
        $manager->flush();
    }
}
