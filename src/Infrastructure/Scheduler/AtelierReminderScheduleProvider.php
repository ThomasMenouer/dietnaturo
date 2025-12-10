<?php

namespace App\Infrastructure\Scheduler;

use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use App\Application\Ateliers\Message\SendAtelierReminderMessage;

#[AsSchedule('atelier_reminders')]
class AtelierReminderScheduleProvider implements ScheduleProviderInterface
{
    public function getSchedule(): Schedule
    {
        return (new Schedule())
            // Tous les jours à 8h
            //->add(RecurringMessage::cron('0 8 * * *', new SendAtelierReminderMessage()));
            ->add(RecurringMessage::cron('*/1 * * * *', new SendAtelierReminderMessage()));

            
    }
}