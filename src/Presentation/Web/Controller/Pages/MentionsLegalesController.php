<?php


namespace App\Presentation\Web\Controller\Pages;


use App\Application\Pages\MentionsLegales\UseCase\GetMentionsLegalesUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MentionsLegalesController extends AbstractController
{
    #[Route('/mentions-legales', name: 'mentions_legales')]
    public function index(GetMentionsLegalesUseCase $getMentionsLegalesUseCase): Response
    {
        $mentions_legales = $getMentionsLegalesUseCase->execute();
        
        return $this->render('pages/mentions_legales.html.twig', [
            'mentions_legales' => $mentions_legales
        ]);
    }
}
