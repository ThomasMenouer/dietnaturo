<?php

namespace App\Presentation\Web\Controller\Pages;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Domain\Pages\Repository\ActivitiesRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ActivitiesController extends AbstractController
{
    #[Route('/activities', name: 'activities')]
    public function index(ActivitiesRepositoryInterface $activitiesRepositoryInterface): Response
    {
        $activities = $activitiesRepositoryInterface->getAllActivities();
        return $this->render('pages/activities.html.twig', [
            'controller_name' => 'ActivitiesController',
            'activities' => $activities
        ]);
    }
}
