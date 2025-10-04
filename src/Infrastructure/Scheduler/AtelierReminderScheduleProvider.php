<?php

namespace App\Infrastructure\Scheduler;


use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use App\Application\Mailers\UseCase\SendAtelierReminderUseCase;

#[AsSchedule('atelier_reminders')]
class AtelierReminderScheduleProvider implements ScheduleProviderInterface
{
    public function __construct(private SendAtelierReminderUseCase $useCase) {}

    public function getSchedule(): Schedule
    {
        return (new Schedule())
            // Tous les jours à 8h du matin
            ->add(RecurringMessage::cron('0 8 * * *', $this->useCase));
    }
}
