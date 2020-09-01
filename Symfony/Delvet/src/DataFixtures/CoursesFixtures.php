<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Courses;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Cocur\Slugify\Slugify;


class CoursesFixtures extends Fixture  implements FixtureGroupInterface

{
    public static function getGroups(): array
     {
         return ['Courses'];
     }


    public function __construct()
    {}
    

   

    public function load(ObjectManager $manager)
    {

        $categories = [];

        for($i=0;$i<=5;$i++)
        {
        $categorie=new Categories();
        $name=$categorie->setName('nom de la categories')->getName();
        $slugify=new Slugify();
        $slug = $slugify->slugify($name);
        $categorie->setSlug( $slug );   
        $manager->persist($categorie);
        $categories[]=$categorie;
        
        }
        $manager->flush();
       $courses=[];
        for($i=0;$i<=100;$i++)
        {
        $course=new Courses();
        $course->setName('nom du cours');
        $course->setFileName('no_image.jpg');
        $course->setContent('un cours prototype');
        $course->setDescription('un cours');
        $course->setDateCreate(new DateTime());
        $course->setNumberView(rand(0 , 1000));
        // $categories_id=[];
        // foreach($categories as $categorie){
        //     $categories_id[]=$categorie->getId();
        // }
     
        // $categorie_cour=rand(0, count($categories_id));
        // $id=$categories_id[$categorie_cour];
        // $course->setCategories($id);
        $manager->persist($course);
        $courses[]=$course;
        }
        $manager->flush();
    }
}
