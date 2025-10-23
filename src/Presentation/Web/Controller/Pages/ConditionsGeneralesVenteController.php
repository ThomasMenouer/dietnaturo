<?php

namespace App\Presentation\Web\Controller\Pages;

use App\Application\Pages\ConditionsGeneralesVente\UseCase\GetConditionsGeneralesVenteUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Domain\Pages\Repository\ConditionsGeneralesVenteRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ConditionsGeneralesVenteController extends AbstractController
{
    #[Route('/conditions-generales-vente', name: 'conditions_generales_vente')]
    public function index(GetConditionsGeneralesVenteUseCase $getConditionsGeneralesVenteUseCase): Response
    {
        $conditions_generales_vente = $getConditionsGeneralesVenteUseCase->execute();
        
        return $this->render('pages/conditions_generales_vente.html.twig', [
            'conditions_generales_vente' => $conditions_generales_vente
        ]);
    }
}
