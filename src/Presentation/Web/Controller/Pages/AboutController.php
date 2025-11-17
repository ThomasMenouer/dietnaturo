<?php

namespace App\Presentation\Web\Controller\Pages;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\Pages\About\UseCase\GetAboutUseCase;
use App\Application\Pages\About\UseCase\GetApprocheUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AboutController extends AbstractController
{
    #[Route('/about', name: 'about')]
    public function index(GetAboutUseCase $getAboutUseCase, GetApprocheUseCase $getApprocheUseCase): Response
    {
        $about = $getAboutUseCase->execute();
        $approche = $getApprocheUseCase->execute();
        
        return $this->render('pages/about.html.twig', [
            'controller_name' => 'Activités',
            'about' => $about,
            'approche' => $approche,
        ]);
    }
}
