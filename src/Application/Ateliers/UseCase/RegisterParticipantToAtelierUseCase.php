<?php

namespace App\Application\Ateliers\UseCase;

use App\Domain\Ateliers\Entity\Participants;
use App\Domain\Ateliers\Entity\Ateliers;
use App\Domain\Ateliers\Repository\ParticipantsRepositoryInterface;
use App\Domain\Mailer\SendMailInterface;
use Doctrine\ORM\EntityManagerInterface;

class RegisterParticipantToAtelierUseCase
{
    public function __construct(
        private ParticipantsRepositoryInterface $participantsRepository,
        private EntityManagerInterface $em,
        private SendMailInterface $mailer
    ) {}

    public function execute(Participants $participant, Ateliers $atelier): string
    {
        
        // Vérifie s'il existe déjà
        $existing = $this->participantsRepository->findOneByEmailAndAtelier(
            $participant->getEmail(),
            $atelier
        );

        if ($existing) {
            return 'already_registered';
        }

        $participant->setAteliers($atelier);
        $participant->setDate($atelier->getDate());

        $this->em->persist($participant);
        $this->em->flush();

        $this->mailer->sendMailInscriptionAtelier($participant);

        return 'success';
    }
}
