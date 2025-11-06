<?php

namespace App\Infrastructure\Scheduler;


use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use App\Application\Blog\Message\RefreshInstagramTokenMessage;


#[AsSchedule('instagram_token_refresh')]
class InstagramTokenScheduleProvider implements ScheduleProviderInterface
{
    public function getSchedule(): Schedule
    {
        return (new Schedule())
            // Tous les jours à 2h du matin
            ->add(RecurringMessage::cron('0 0 1 * *', new RefreshInstagramTokenMessage()));
    }
}
