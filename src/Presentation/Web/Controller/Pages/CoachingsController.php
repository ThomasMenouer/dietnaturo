<?php

namespace App\Presentation\Web\Controller\Pages;


use App\Application\Pages\Coachings\UseCase\GetAllCoachingsAndCyclesUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CoachingsController extends AbstractController
{
    #[Route('/pages/coachings', name: 'coachings')]
    public function index(GetAllCoachingsAndCyclesUseCase $getAllCoachingsAndCyclesUseCase): Response
    {
        $coachings_page = $getAllCoachingsAndCyclesUseCase->execute();

        
        return $this->render('pages/coachings.html.twig', [
            'controller_name' => 'CoachingsController',
            'coachings_page' => $coachings_page['coachings'],
            'cycles' => $coachings_page['cycles'],
        ]);
    }
}
