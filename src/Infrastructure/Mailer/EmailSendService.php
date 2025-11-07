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
        private BodyRendererInterface $renderer
    ) {}

    public function sendMailInscriptionAtelier(string $email, string $atelierTitle, string $date): void
    {

        $email = (new TemplatedEmail())
            ->from('dietnaturo@gmail.com')
            ->to($email)
            ->subject('Confirmation d\'inscription')
            ->htmlTemplate('mails/inscription_atelier.html.twig')
            ->context([
                'atelier' => $atelierTitle,
                'date' => $date,
            ]);


        $this->renderer->render($email);
        $this->mailer->send($email);
    }



    public function sendEmail(Participants $participants, string $to, string $subject, string $content): void
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
            ->to('dietnaturo@gmail.com')
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
            ->from('dietnaturo@gmail.com')
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
        \DateTimeInterface $date,
        ?string $link,
        bool $isVisio,
        string $slug,
        string $typeAtelier
    ): void {

        $template = match ($typeAtelier) {
            TypeAtelier::ATELIER->value => 'mails/rappels/atelier.html.twig',
            TypeAtelier::ATELIER_FLASH->value => 'mails/rappels/atelier_flash.html.twig',
            TypeAtelier::COURS_YOGA->value => 'mails/rappels/cours_yoga.html.twig',
        };

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
                'https://127.0.0.1:8000/newsletter/unsubscribe/%s',
                $subscriber->getUnsubscribeToken()
            );

            $email = (new TemplatedEmail())
                ->from('dietnaturo@gmail.com')
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
