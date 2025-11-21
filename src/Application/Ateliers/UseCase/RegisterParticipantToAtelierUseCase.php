<?php

namespace App\Application\Ateliers\UseCase;

use App\Domain\Ateliers\Entity\Participants;
use App\Domain\Ateliers\Entity\Ateliers;
use App\Domain\Ateliers\Repository\ParticipantsRepositoryInterface;
use App\Domain\Mailer\SendMailInterface;

class RegisterParticipantToAtelierUseCase
{
    public function __construct(
        private ParticipantsRepositoryInterface $participantsRepository,
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

        $this->participantsRepository->save($participant);

        $this->mailer->sendMailInscriptionAtelier($participant->getEmail(), 
            $participant->getAteliers()->getTitle(), 
            $participant->getFormattedDate(),
            $participant->getFormattedDateHour()
        );

        return 'success';
    }
}
