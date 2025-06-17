<?php

namespace App\Presentation\Web\Controller\Pages;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Infrastructure\Persistence\Doctrine\Repository\Pages\Activities\ActivitiesRepository;

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
