<?php

namespace App\Presentation\Web\Controller\Ateliers;

use App\Domain\Ateliers\Entity\Ateliers;
use App\Domain\Ateliers\Entity\Participants;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Presentation\Web\Form\ParticipantsType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use App\Application\Ateliers\UseCase\GetAllAteliersUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Application\Ateliers\UseCase\RegisterParticipantToAtelierUseCase;
use App\Application\Newsletter\UseCase\RegisterNewsletterSubscriberUseCase;

#[Route('/ateliers', name: 'ateliers_')]
class AteliersController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(GetAllAteliersUseCase $getAllAteliersUseCase, Request $request, RegisterNewsletterSubscriberUseCase $newsletterUseCase): Response
    {
        $ateliers = $getAllAteliersUseCase->getAllAteliers();

        /* Newsletter Subscription Form */
        $form = $this->createForm(\App\Presentation\Web\Form\NewsletterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $result = $newsletterUseCase->execute($email);

            if ($result === 'already_registered') {
                $this->addFlash('warning', 'Vous êtes déjà inscrit à la newsletter.');
            } else {
                $this->addFlash('success', 'Merci pour votre inscription !');
            }

            return $this->redirectToRoute('ateliers_index');
        }

        // return $this->render('maintenance/maintenance.html.twig');

        return $this->render('Ateliers/ateliers.html.twig', [
            'ateliers' => $ateliers,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{slug}', name: 'detail')]
    public function showAtelier(
        #[MapEntity(mapping: ['slug' => 'slug'])] Ateliers $atelier,
        Request $request,
        RegisterParticipantToAtelierUseCase $registerParticipantToAtelierUseCase
    ): Response {
        $participant = new Participants();

        $form = $this->createForm(ParticipantsType::class, $participant, ['atelier' => $atelier]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $result = $registerParticipantToAtelierUseCase->execute($participant, $atelier);

            if ($result === 'already_registered') {

                $this->addFlash('danger', 'Vous êtes déjà inscrit à cet atelier.');
            } else {
                $this->addFlash('success', 'Votre inscription a été enregistrée avec succès. Un mail vous sera envoyé.');
            }

            return $this->redirectToRoute('ateliers_index');
        }

        return $this->render('Ateliers/atelier_detail.html.twig', [
            'atelier' => $atelier,
            'form' => $form->createView(),
        ]);
    }
}
