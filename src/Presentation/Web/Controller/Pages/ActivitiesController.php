<?php

namespace App\Presentation\Web\Controller\Pages;

use App\Application\Pages\Activities\UseCase\GetActivitiesUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Domain\Pages\Repository\ActivitiesRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ActivitiesController extends AbstractController
{
    #[Route('/activities', name: 'activities')]
    public function index(GetActivitiesUseCase $getActivitiesUseCase): Response
    {
        $activities = $getActivitiesUseCase->execute();
        
        return $this->render('pages/activities.html.twig', [
            'controller_name' => 'ActivitiesController',
            'activities' => $activities
        ]);
    }
}
