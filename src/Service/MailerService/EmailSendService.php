<?php

namespace App\Service\MailerService;

use App\Entity\Ateliers\Participants;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class EmailSendService
{
    public function __construct(private MailerInterface $mailer)
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
                'date' => $participants->getFormattedDate(),
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
            $email = (new Email())
            ->from('dietnaturo@gmail.com')
            ->to($participant->getEmail())
            ->subject($subject)
            ->html($content);
        
            $this->mailer->send($email);
        }
    }

    public function sendEmailContact(array $data): void
    {
        $email = (new TemplatedEmail())
        ->from($data['Email'])
        ->to ('dietnaturo@gmail.com')
        ->subject('Demande de contact via site web')
        ->htmlTemplate('mails/contact.html.twig')
        ->context([
            'data' => $data
        ]);


        $this->mailer->send($email);
    }

}