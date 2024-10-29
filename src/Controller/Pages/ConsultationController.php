<?php

namespace App\Controller\Pages;

use App\Repository\Pages\Consultation\ConsultationsRepository;
use App\Repository\Pages\Consultation\DeroulementConsultationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsultationController extends AbstractController
{
    #[Route('/consultation', name: 'consultation')]
    public function index(ConsultationsRepository $consultationsRepository, DeroulementConsultationRepository $deroulementConsultationRepository): Response
    {
        $consultations = $consultationsRepository->findAll();
        $deroulements = $deroulementConsultationRepository->findAll();


        return $this->render('pages/consultation.html.twig', [
            'controller_name' => 'ConsultationController',
            'consultations' => $consultations,
            'deroulements' => $deroulements
        ]);
    }
}
