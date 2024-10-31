<?php

namespace App\Controller\Pages;

use App\Repository\Pages\Activities\ActivitiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActivitiesController extends AbstractController
{
    #[Route('/activities', name: 'activities')]
    public function index(ActivitiesRepository $activitiesRepository): Response
    {
        $activities = $activitiesRepository->findAll();
        return $this->render('pages/activities.html.twig', [
            'controller_name' => 'ActivitiesController',
            'activities' => $activities
        ]);
    }
}
