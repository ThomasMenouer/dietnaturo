<?php

namespace App\Controller\Pages;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoachingsController extends AbstractController
{
    #[Route('/pages/coachings', name: 'coachings')]
    public function index(): Response
    {
        return $this->render('pages/coachings/index.html.twig', [
            'controller_name' => 'CoachingsController',
        ]);
    }
}
