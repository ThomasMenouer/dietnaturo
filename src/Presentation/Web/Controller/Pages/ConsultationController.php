<?php

namespace App\Presentation\Web\Controller\Pages;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Infrastructure\Persistence\Doctrine\Repository\Pages\Consultation\ConsultationsRepository;
use App\Infrastructure\Persistence\Doctrine\Repository\Pages\Consultation\DeroulementConsultationRepository;

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
