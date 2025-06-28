<?php

namespace App\Presentation\Web\Controller\Pages;

use App\Application\Pages\Faqs\UseCase\GetAllFaqsUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FaqController extends AbstractController
{
    #[Route('/faq', name: 'faq')]
    public function index(GetAllFaqsUseCase $getAllFaqsUseCase): Response
    {

        $faqs = $getAllFaqsUseCase->execute();

        return $this->render('pages/faq.html.twig', [
            'controller_name' => 'FAQ',
            'faqs' => $faqs,
        ]);
    }
}
