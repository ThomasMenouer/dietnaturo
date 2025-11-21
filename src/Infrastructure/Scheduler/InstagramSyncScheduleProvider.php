<?php

namespace App\Infrastructure\Scheduler;

use App\Application\Blog\Message\SyncInstagramMediaMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;

#[AsSchedule('instagram_sync')]
final class InstagramSyncScheduleProvider implements ScheduleProviderInterface
{
    public function getSchedule(): Schedule
    {
        return (new Schedule())
            // Tous les jours à 3h00 du matin
            ->add(RecurringMessage::cron('0 3 * * *', new SyncInstagramMediaMessage()));
    }
}
