<?php

namespace App\Application\Mailers\UseCase;

use App\Domain\Ateliers\Repository\AteliersRepositoryInterface;
use App\Domain\Mailer\SendMailInterface;
use DateTimeImmutable;

class SendAtelierReminderUseCase
{
    public function __construct(
        private AteliersRepositoryInterface $ateliersRepository,
        private SendMailInterface $mailer
    ) {}

    public function execute(): void
    {
        $tomorrow = (new DateTimeImmutable('+1 day'))->setTime(0, 0);
        $afterTomorrow = $tomorrow->modify('+1 day');

        // On récupère tous les ateliers entre demain 00h00 et après-demain 00h00
        $ateliers = $this->ateliersRepository->findBetweenDates($tomorrow, $afterTomorrow);


        foreach ($ateliers as $atelier) {
            $participants = $atelier->getParticipants();
            if ($participants->isEmpty()) {
                continue;
            }

            $this->mailer->sendEmailReminderAtelier(
                $participants->toArray(),
                $atelier->getTitle(),
                $atelier->getFormattedDate(),
                $atelier->getFormattedDateHour(),
                $atelier->getLink(),
                $atelier->getIsVisio(),
                $atelier->getTypeAtelier()->value
            );
        }
    }
}
