<?php

namespace App\Controller\Pages;

use App\Repository\Pages\CoachingsRepository;
use App\Repository\Pages\CycleCoachingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoachingsController extends AbstractController
{
    #[Route('/pages/coachings', name: 'coachings')]
    public function index(CoachingsRepository $coachingsRepository, CycleCoachingsRepository $cycleCoachingsRepository): Response
    {

        $coachings_page = $coachingsRepository->findAll();
        $cycles = $cycleCoachingsRepository->findAll();

        return $this->render('pages/coachings.html.twig', [
            'controller_name' => 'CoachingsController',
            'coachings_page' => $coachings_page,
            'cycles' => $cycles,
        ]);
    }
}
