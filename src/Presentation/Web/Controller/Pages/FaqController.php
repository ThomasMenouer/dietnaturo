<?php

namespace App\Presentation\Web\Controller\Pages;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Infrastructure\Persistence\Doctrine\Repository\FaqsRepository;

class FaqController extends AbstractController
{
    #[Route('/faq', name: 'faq')]
    public function index(FaqsRepository $faqsRepository): Response
    {

        $faqs = $faqsRepository->findAll();

        return $this->render('pages/faq.html.twig', [
            'faqs' => $faqs,
        ]);
    }
}
