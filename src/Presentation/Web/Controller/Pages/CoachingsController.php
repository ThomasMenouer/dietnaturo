<?php

namespace App\Presentation\Web\Controller\Pages;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Infrastructure\Persistence\Doctrine\Repository\Pages\Coaching\CoachingsRepository;
use App\Infrastructure\Persistence\Doctrine\Repository\Pages\Coaching\CycleCoachingsRepository;

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
