<?php

namespace App\Presentation\Web\Controller\Pages;

use App\Application\Pages\Home\UseCase\GetAllHomeConctentUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(GetAllHomeConctentUseCase $getAllHomeConctentUseCase): Response
    {
        $homeContent = $getAllHomeConctentUseCase->execute();

        return $this->render('pages/home.html.twig', [
            'controller_name' => 'Accueil',
                'homeContent' => $homeContent,
            ]
        );
    }
}
