<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contributors;
use App\Repository\ContributorsRepository;
use Symfony\Component\HttpFoundation\Response;

class ContributorsController extends AbstractController
{   

    
    /**
     * @Route("/contributors", name="contributors")
     */
    public function index(ContributorsRepository $contributorsRepository)
    {
       $user=$this->getUser();
       if($user === null)
       {
            return $this->redirectToRoute('app_register');
       }
        return $this->render('contributors/index.html.twig', [
            'contributors' => $contributorsRepository->findAll(),
           
        ]);
    }

    /**
     * @Route("/contributors/course/{id}", name="contributorsCourse")
     */
    public function contributorCourse( Contributors $contributor ,ContributorsRepository $contributorsRepository)
    {       
        $user=$this->get('security.token_storage')->getToken()->getUser();   
         
        if(  $contributor->getUserId() == $user->getId() )
        {
            $contributor= $contributorsRepository->findByUserId($user->getId());
            
        }
 
        return $this->render('contributors/contributorCourse.html.twig', [
            'courses' => $contributor->getCourseCreate(),
            'contributor'=> $contributor
        ]);
    } 
    
}
