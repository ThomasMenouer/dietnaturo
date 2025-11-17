<?php

namespace App\Presentation\Web\Controller\Newsletter;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Application\Newsletter\UseCase\RemoveSubscriberUseCase;

#[Route('/newsletter', name: 'newsletter_')]
class NewsletterController extends AbstractController
{

    #[Route('/unsubscribe/{token}', name: 'unsubscribe', methods: ['GET'])]
    public function unsubscribe(string $token, RemoveSubscriberUseCase $removeSubscriberUseCase): Response
    {
        $unsubscribe = $removeSubscriberUseCase->execute($token);

        if ($unsubscribe) {

            $this->addFlash('success', 'Vous avez été désinscrit de la newsletter.');
        } else {
            $this->addFlash('warning', 'Lien de désinscription invalide.');
        }

        return $this->redirectToRoute('ateliers_index');
    }
}
