<?php

namespace App\Controller\Ateliers;

use App\Form\ParticipantsType;
use App\Entity\Ateliers\Ateliers;
use App\Entity\Ateliers\Participants;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\Ateliers\AteliersRepository;
use App\Service\MailerService\EmailSendService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/ateliers', name: 'ateliers_')]
class AteliersController extends AbstractController
{
    public function __construct(private EmailSendService $emailService)
    {
        $this->emailService = $emailService;
    }

    #[Route('/', name: 'index')]
    public function index(AteliersRepository $ateliersRepository): Response
    {
        $ateliers = $ateliersRepository->findAll();

        return $this->render('Ateliers/ateliers.html.twig', [
            'ateliers' => $ateliers,
        ]);
    }

    #[Route('/{slug}', name: 'detail')]
    public function showAtelier(#[MapEntity(mapping: ['slug' => 'slug'])] Ateliers $ateliers, EntityManagerInterface $em, Request $request): Response
    {

        $participant = new Participants();
        $participant->setAteliers($ateliers);

        $form = $this->createForm(ParticipantsType::class, $participant, ['atelier' => $ateliers]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Vérifier que le participant n'est pas déjà inscrit
            $participantExist = $em->getRepository(Participants::class)->findOneBy([
            'email' => $participant->getEmail(),
            'dateDisponible' => $participant->getDateDisponible(),
            'ateliers' => $participant->getAteliers()
            
            ]);

            if ($participantExist) {
                
                $this->addFlash('danger', 'Vous êtes déjà inscrit à cet atelier.');
            }
            else{

                $em->persist($participant);
                $em->flush();
    
                $this->addFlash('success', 'Votre inscription a été enregistrée avec succès. Un mail vous sera envoyé.');

                // Envoi d'un mail de confirmation
                $this->emailService->sendMailInscriptionAtelier($participant);
        
            }
            
            return $this->redirectToRoute('ateliers_index');

        }

        return $this->render('Ateliers/atelier_detail.html.twig', [
            'atelier' => $ateliers,
            'form' => $form->createView(),
        ]);
    }

}
