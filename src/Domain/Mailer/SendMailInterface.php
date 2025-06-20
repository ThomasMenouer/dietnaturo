<?php

namespace App\Domain\Mailer;

use App\Domain\Ateliers\Entity\Participants;

interface SendMailInterface
{
    public function sendMailInscriptionAtelier(Participants $participant): void;

    public function sendEmail(Participants $participants,string $to, string $subject, string $content): void;

    public function sendEmailToAllParticipants(array $participants, string $subject, string $content): void;

    public function sendEmailContact(array $data): void;
}