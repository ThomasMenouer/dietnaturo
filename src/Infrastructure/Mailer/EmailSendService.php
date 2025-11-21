<?php

namespace App\Infrastructure\Mailer;

use Symfony\Component\Mime\Email;
use App\Domain\Mailer\SendMailInterface;
use App\Domain\Ateliers\Enum\TypeAtelier;
use App\Domain\Ateliers\Entity\Participants;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\BodyRendererInterface;

class EmailSendService implements SendMailInterface
{
    public function __construct(
        private MailerInterface $mailer,
        private BodyRendererInterface $renderer,
        private string $fromAddress
    ) {}

    /**
     * Envoie un email de confirmation d'inscription à un atelier
     *
     * @param string $email
     * @param string $atelierTitle
     * @param string $date
     * @param string $dateHour
     * @return void
     */
    public function sendMailInscriptionAtelier(string $email, string $atelierTitle, string $date, string $dateHour): void
    {

        $email = (new TemplatedEmail())
            ->from($this->fromAddress)
            ->to($email)
            ->subject('Confirmation d\'inscription')
            ->htmlTemplate('mails/inscription_atelier.html.twig')
            ->context([
                'atelier' => $atelierTitle,
                'date' => $date,
                'dateHour' => $dateHour,
            ]);


        $this->renderer->render($email);
        $this->mailer->send($email);
    }



    public function sendEmail(Participants $participants, string $to, string $subject, string $content): void
    {
        $email = (new Email())
            ->from($this->fromAddress)
            ->to($participants->getEmail())
            ->subject($subject)
            ->html($content);

        $this->mailer->send($email);
    }

    public function sendEmailToAllParticipants(array $participants, string $subject, string $content): void
    {

        foreach ($participants as $participant) {
            $email = (new Email())
                ->from($this->fromAddress)
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
            ->to($this->fromAddress)
            ->subject('Demande de contact via site web')
            ->htmlTemplate('mails/contact.html.twig')
            ->context([
                'data' => $data
            ]);

        $this->renderer->render($email);
        $this->mailer->send($email);
    }

    public function sendInvoiceAndEbooks(string $email, string $firstname, string $invoicePath, array $ebookPaths): void
    {
        $mail = (new TemplatedEmail())
            ->from($this->fromAddress)
            ->to($email)
            ->subject('Votre commande et vos ebooks')
            ->htmlTemplate('mails/order.html.twig')
            ->context([
                'firstname' => $firstname,
            ])
            ->attachFromPath($invoicePath, 'facture.pdf');

        foreach ($ebookPaths as $ebookPath) {
            $filename = basename($ebookPath);
            $mail->attachFromPath($ebookPath, $filename);
        }

        $this->renderer->render($mail);
        $this->mailer->send($mail);
    }

    public function sendEmailReminderAtelier(
        array $participants,
        string $title,
        string $date,
        string $dateHour,
        ?string $link,
        bool $isVisio,
        string $typeAtelier
    ): void {

        // Choix du template selon le type et si c'est en visio
        if ($isVisio) {
            $template = match ($typeAtelier) {
                TypeAtelier::ATELIER->value => 'mails/rappels/atelier_visio.html.twig',
                TypeAtelier::ATELIER_FLASH->value => 'mails/rappels/atelier_flash_visio.html.twig',
                TypeAtelier::COURS_YOGA->value => 'mails/rappels/cours_yoga_visio.html.twig',
            };
        } else {
            $template = match ($typeAtelier) {
                TypeAtelier::ATELIER->value => 'mails/rappels/atelier.html.twig',
                TypeAtelier::ATELIER_FLASH->value => 'mails/rappels/atelier_flash.html.twig',
                TypeAtelier::COURS_YOGA->value => 'mails/rappels/cours_yoga.html.twig',
            };
        }

        foreach ($participants as $participant) {
            $email = (new TemplatedEmail())
                ->from('dietnaturo@gmail.com')
                ->to($participant->getEmail())
                ->subject('Rappel : votre ' . $title . ' approche !')
                ->htmlTemplate($template)
                ->context([
                    'participant' => $participant,
                    'title' => $title,
                    'date' => $date,
                    'dateHour' => $dateHour,
                    'link' => $link,
                    'isVisio' => $isVisio,
                ]);
            $this->renderer->render($email);
            $this->mailer->send($email);
        }
    }


    /**
     * Envoie un email à tous les abonnés de la newsletter
     * @param array $subscribers
     * @param string $subject
     * @param string $content
     * @return void
     */
    public function sendEmailToAllSubscribers(array $subscribers, string $subject, string $content): void
    {
        foreach ($subscribers as $subscriber) {
            $unsubscribeLink = sprintf(
                'https://www.dietnaturo.fr/newsletter/unsubscribe/%s',
                $subscriber->getUnsubscribeToken()
            );

            $email = (new TemplatedEmail())
                ->from($this->fromAddress)
                ->to($subscriber->getEmail())
                ->subject($subject)
                ->htmlTemplate('mails/newsletter/newsletter.html.twig')
                ->context([
                    'content' => $content,
                    'unsubscribeLink' => $unsubscribeLink,
                ]);

            $this->renderer->render($email);
            $this->mailer->send($email);
        }
    }
}
