<?php

namespace App\Presentation\Web\Controller\Pages;

use App\Application\Pages\PolitiqueConfidentialite\UseCase\GetPolitiqueConfidentialiteUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PolitiqueConfidentialiteController extends AbstractController
{
    #[Route('/politique-confidentialite', name: 'politique_confidentialite')]
    public function index(GetPolitiqueConfidentialiteUseCase $getPolitiqueConfidentialiteUseCase): Response
    {
        $politique_confidentialite = $getPolitiqueConfidentialiteUseCase->execute();
        
        return $this->render('pages/politique_confidentialite.html.twig', [
            'politique_confidentialite' => $politique_confidentialite
        ]);
    }
}
