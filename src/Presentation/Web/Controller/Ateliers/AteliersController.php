<?php

namespace App\Presentation\Web\Controller\Ateliers;

use App\Domain\Ateliers\Entity\Ateliers;
use App\Domain\Ateliers\Entity\Participants;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Infrastructure\Mailer\EmailSendService;
use App\Presentation\Web\Form\ParticipantsType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use App\Domain\Ateliers\Repository\AteliersRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Application\Ateliers\UseCase\RegisterParticipantToAtelierUseCase;


#[Route('/ateliers', name: 'ateliers_')]
class AteliersController extends AbstractController
{
    public function __construct(private EmailSendService $emailService)
    {
        $this->emailService = $emailService;
    }

    #[Route('/', name: 'index')]
    public function index(AteliersRepositoryInterface $ateliersRepositoryInterface): Response
    {
        $ateliers = $ateliersRepositoryInterface->getAllAteliers();

        return $this->render('Ateliers/ateliers.html.twig', [
            'ateliers' => $ateliers,
        ]);
    }

    #[Route('/{slug}', name: 'detail')]
    public function showAtelier(#[MapEntity(mapping: ['slug' => 'slug'])] Ateliers $atelier, Request $request,
        RegisterParticipantToAtelierUseCase $useCase ): Response 
    {
        
        $participant = new Participants();
        
        $form = $this->createForm(ParticipantsType::class, $participant, ['atelier' => $atelier]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $result = $useCase->execute($participant, $atelier);

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
