<?php

namespace App\Domain\Mailer;

use App\Domain\Ateliers\Entity\Ateliers;
use App\Domain\Ateliers\Entity\Participants;

interface SendMailInterface
{
    public function sendMailInscriptionAtelier(string $email, string $atelierTitle, string $date): void;

    public function sendEmail(Participants $participants,string $to, string $subject, string $content): void;

    public function sendEmailToAllParticipants(array $participants, string $subject, string $content): void;

    public function sendEmailContact(array $data): void;

    public function sendInvoiceAndEbooks(string $email, string $firstname, string $invoicePath, array $ebookPaths): void;

    public function sendEmailReminderAtelier(
        array $participants,
        string $title,
        \DateTimeInterface $date,
        ?string $link,
        bool $isVisio,
        string $slug,
        string $typeAtelier
    ): void;

}