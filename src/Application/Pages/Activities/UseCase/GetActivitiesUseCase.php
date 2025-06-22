<?php 


namespace App\Application\Pages\Activities\UseCase;

use App\Domain\Pages\Repository\ActivitiesRepositoryInterface;

class GetActivitiesUseCase
{

    public function __construct(private ActivitiesRepositoryInterface $activitiesRepository){}

    public function execute(): array
    {
        return $this->activitiesRepository->getAllActivities();
    }
}