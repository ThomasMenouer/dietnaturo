<?php

namespace App\Infrastructure\Mailer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Domain\Mailer\SendMailInterface;
use App\Domain\Ateliers\Enum\TypeAtelier;
use App\Domain\Ateliers\Entity\Participants;
use Twig\Environment;

class EmailSendService implements SendMailInterface
{
    public function __construct(
        private Environment $twig,   // Pour rendre les templates
        private string $fromAddress
    ) {}

    private function sendMail(string $to, string $subject, string $htmlBody): void
    {
        $mail = new PHPMailer(true);

        try {
            // Utilise mail() sur OVH mutualisé
            $mail->isMail();

            // Expéditeur
            $mail->setFrom($this->fromAddress, 'Dietnaturo');

            // Destinataire
            $mail->addAddress($to);

            // Sujet et contenu HTML
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body = $htmlBody;

            $mail->send();
        } catch (Exception $e) {
            // Log ou gestion des erreurs
            error_log("Erreur PHPMailer : " . $mail->ErrorInfo);
        }
    }

    public function sendMailInscriptionAtelier(string $email, string $atelierTitle, string $date, string $dateHour): void
    {
        $html = $this->twig->render('mails/inscription_atelier.html.twig', [
            'atelier' => $atelierTitle,
            'date' => $date,
            'dateHour' => $dateHour,
        ]);

        $this->sendMail($email, 'Confirmation d\'inscription', $html);
    }

    public function sendEmail(Participants $participants, string $to, string $subject, string $content): void
    {
        $this->sendMail($participants->getEmail(), $subject, $content);
    }

    public function sendEmailToAllParticipants(array $participants, string $subject, string $content): void
    {
        foreach ($participants as $participant) {
            $this->sendMail($participant->getEmail(), $subject, $content);
        }
    }

    public function sendEmailContact(array $data): void
    {
        $html = $this->twig->render('mails/contact.html.twig', [
            'data' => $data
        ]);

        $this->sendMail($this->fromAddress, 'Demande de contact via site web', $html);
    }

    public function sendInvoiceAndEbooks(string $email, string $firstname, string $invoicePath, array $ebookPaths): void
    {
        $html = $this->twig->render('mails/order.html.twig', [
            'firstname' => $firstname,
        ]);

        $mail = new PHPMailer(true);
        try {
            $mail->isMail();
            $mail->setFrom($this->fromAddress, 'Dietnaturo');
            $mail->addAddress($email);
            $mail->Subject = 'Votre commande et vos ebooks';
            $mail->isHTML(true);
            $mail->Body = $html;

            // Ajout de la facture
            $mail->addAttachment($invoicePath, 'facture.pdf');

            // Ajout des ebooks
            foreach ($ebookPaths as $ebookPath) {
                $mail->addAttachment($ebookPath, basename($ebookPath));
            }

            $mail->send();
        } catch (Exception $e) {
            error_log("Erreur PHPMailer : " . $mail->ErrorInfo);
        }
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
        foreach ($participants as $participant) {
            // Choix du template selon le type et si c'est en visio
            $template = match (true) {
                $isVisio && $typeAtelier === TypeAtelier::ATELIER->value => 'mails/rappels/atelier_visio.html.twig',
                $isVisio && $typeAtelier === TypeAtelier::ATELIER_FLASH->value => 'mails/rappels/atelier_flash_visio.html.twig',
                $isVisio && $typeAtelier === TypeAtelier::COURS_YOGA->value => 'mails/rappels/cours_yoga_visio.html.twig',
                !$isVisio && $typeAtelier === TypeAtelier::ATELIER->value => 'mails/rappels/atelier.html.twig',
                !$isVisio && $typeAtelier === TypeAtelier::ATELIER_FLASH->value => 'mails/rappels/atelier_flash.html.twig',
                !$isVisio && $typeAtelier === TypeAtelier::COURS_YOGA->value => 'mails/rappels/cours_yoga.html.twig',
            };

            $html = $this->twig->render($template, [
                'participant' => $participant,
                'title' => $title,
                'date' => $date,
                'dateHour' => $dateHour,
                'link' => $link,
                'isVisio' => $isVisio,
            ]);

            $this->sendMail($participant->getEmail(), 'Rappel : votre ' . $title . ' approche !', $html);
        }
    }

    public function sendEmailToAllSubscribers(array $subscribers, string $subject, string $content): void
    {
        foreach ($subscribers as $subscriber) {
            $unsubscribeLink = sprintf(
                'https://www.dietnaturo.fr/newsletter/unsubscribe/%s',
                $subscriber->getUnsubscribeToken()
            );

            $html = $this->twig->render('mails/newsletter/newsletter.html.twig', [
                'content' => $content,
                'unsubscribeLink' => $unsubscribeLink,
            ]);

            $this->sendMail($subscriber->getEmail(), $subject, $html);
        }
    }
}
