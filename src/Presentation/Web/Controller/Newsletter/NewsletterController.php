<?php

namespace App\Presentation\Web\Controller\Newsletter;

use App\Presentation\Web\Form\NewsletterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Application\Newsletter\UseCase\RegisterNewsletterSubscriberUseCase;
use App\Infrastructure\Persistence\Doctrine\Repository\NewsletterRepository\NewsletterSubscriberRepository;

#[Route('/newsletter', name: 'newsletter_')]
class NewsletterController extends AbstractController
{

    #[Route('/unsubscribe/{token}', name: 'unsubscribe', methods: ['GET'])]
    public function unsubscribe(string $token, NewsletterSubscriberRepository $repo): Response
    {
        $subscriber = $repo->findOneBy(['unsubscribeToken' => $token]);

        if ($subscriber) {
            $em = $repo->getEntityManager();
            $em->remove($subscriber);
            $em->flush();
            $this->addFlash('success', 'Vous avez été désinscrit de la newsletter.');
        } else {
            $this->addFlash('warning', 'Lien de désinscription invalide.');
        }

        return $this->redirectToRoute('ateliers_index');
    }
}
