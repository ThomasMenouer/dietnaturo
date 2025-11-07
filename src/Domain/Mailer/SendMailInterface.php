<?php

namespace App\Domain\Mailer;

use App\Domain\Ateliers\Entity\Participants;

interface SendMailInterface
{
    /**
     * Envoie un email de confirmation d'inscription à un atelier
     * @param string $email
     * @param string $atelierTitle
     * @param string $date
     * @return void
     */
    public function sendMailInscriptionAtelier(string $email, string $atelierTitle, string $date): void;

    /**
     * Envoie un email à un participant
     * @param Participants $participants
     * @param string $to
     * @param string $subject
     * @param string $content
     * @return void
     */
    public function sendEmail(Participants $participants,string $to, string $subject, string $content): void;

    /**
     * Envoie un email à tous les participants
     * @param array $participants
     * @param string $subject
     * @param string $content
     * @return void
     */
    public function sendEmailToAllParticipants(array $participants, string $subject, string $content): void;

    /**
     * Envoie un email de contact
     * @param array $data
     * @return void
     */
    public function sendEmailContact(array $data): void;

    /**
     * Envoie une facture et des ebooks par email
     * @param string $email
     * @param string $firstname
     * @param string $invoicePath
     * @param array $ebookPaths
     * @return void
     */
    public function sendInvoiceAndEbooks(string $email, string $firstname, string $invoicePath, array $ebookPaths): void;

    /**
     * Envoie un email de rappel aux participants d'un atelier
     *
     * @param array $participants
     * @param string $title
     * @param \DateTimeInterface $date
     * @param string|null $link
     * @param boolean $isVisio
     * @param string $slug
     * @param string $typeAtelier
     * @return void
     */
    public function sendEmailReminderAtelier(
        array $participants,
        string $title,
        \DateTimeInterface $date,
        ?string $link,
        bool $isVisio,
        string $slug,
        string $typeAtelier
    ): void;


    /**
     * Envoie un email à tous les abonnés de la newsletter
     * @param array $subscribers
     * @param string $subject
     * @param string $content
     * @return void
     */
    public function sendEmailToAllSubscribers(array $subscribers, string $subject, string $content): void;

}