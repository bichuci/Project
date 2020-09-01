<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LegalMentionsController extends AbstractController
{
    /**
     * @Route("/legal/mentions", name="legal_mentions")
     */
    public function index()
    {
        return $this->render('legal_mentions/index.html.twig', [
            'controller_name' => 'LegalMentionsController',
        ]);
    }
}
