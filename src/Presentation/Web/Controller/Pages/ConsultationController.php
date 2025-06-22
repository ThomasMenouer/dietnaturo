<?php

namespace App\Presentation\Web\Controller\Pages;


use App\Application\Pages\Consultations\UseCase\GetAllConsultationsAndDeroulementUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConsultationController extends AbstractController
{
    #[Route('/consultation', name: 'consultation')]
    public function index(GetAllConsultationsAndDeroulementUseCase $getAllConsultationsAndDeroulementUseCase): Response
    {

        $consultations = $getAllConsultationsAndDeroulementUseCase->execute();


        return $this->render('pages/consultation.html.twig', [
            'controller_name' => 'ConsultationController',
            'consultations' => $consultations['consultations'],
            'deroulements' => $consultations['deroulement'],
        ]);
    }
}
