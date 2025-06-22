<?php


namespace App\Application\Pages\Coachings\UseCase;

use App\Domain\Pages\Repository\CoachingsRepositoryInterface;
use App\Domain\Pages\Repository\CycleCoachingsRepositoryInterface;

final class GetAllCoachingsAndCyclesUseCase
{

    public function __construct(private CoachingsRepositoryInterface $coachingsRepository,
         private CycleCoachingsRepositoryInterface $cycleCoachingsRepositoryInterface){}

    public function execute(): array
    {
        $coachings = $this->coachingsRepository->getAllCoachings();
        $cycles = $this->cycleCoachingsRepositoryInterface->getAllCycles();

        return [
            'coachings' => $coachings,
            'cycles' => $cycles,
        ];
    }
}