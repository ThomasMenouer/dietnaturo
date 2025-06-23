<?php

namespace App\Presentation\Web\Controller\Pages;


use App\Application\Pages\Consultations\UseCase\GetAllConsultationsAndDeroulementUseCase;
use App\Application\Pages\Consultations\UseCase\GetAllPriceConsultationsUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConsultationController extends AbstractController
{
    #[Route('/consultation', name: 'consultation')]
    public function index(GetAllConsultationsAndDeroulementUseCase $getAllConsultationsAndDeroulementUseCase, 
    GetAllPriceConsultationsUseCase $getAllPriceConsultationsUseCase): Response
    {

        $consultations = $getAllConsultationsAndDeroulementUseCase->execute();
        $priceConsultations = $getAllPriceConsultationsUseCase->execute();



        return $this->render('pages/consultation.html.twig', [
            'controller_name' => 'ConsultationController',
            'consultations' => $consultations['consultations'],
            'deroulements' => $consultations['deroulement'],
            'priceConsultations' => $priceConsultations,
        ]);
    }
}
