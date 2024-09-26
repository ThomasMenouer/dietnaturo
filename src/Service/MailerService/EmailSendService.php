<?php

namespace App\Service\MailerService;

use App\Entity\Ateliers\Participants;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class EmailSendService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMailInscriptionAtelier(Participants $participants): void
    {

        $email = (new TemplatedEmail())
            ->from('dietnaturo@gmail.com')
            ->to ($participants->getEmail())
            ->subject('Confirmation d\'inscription')
            ->htmlTemplate('mails/inscription_atelier.html.twig')
            ->context([
                'atelier' => $participants->getAteliers()->getTitle(),
                'date' => $participants->getDateDisponible(),
            ]);


            $this->mailer->send($email);
        }



    public function sendEmail(Participants $participants,string $to, string $subject, string $content): void
    {
        $email = (new Email())
            ->from('dietnaturo@gmail.com')
            ->to($participants->getEmail())
            ->subject($subject)
            ->html($content);
        
        $this->mailer->send($email);
    }

    public function sendEmailToAllParticipants(array $participants, string $subject, string $content): void
    {
        foreach ($participants as $participant) {
            $this->sendEmail($participant, $participant->getEmail(), $subject, $content);
        }
    }

}