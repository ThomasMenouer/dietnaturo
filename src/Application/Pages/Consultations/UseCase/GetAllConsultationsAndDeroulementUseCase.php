<?php


namespace App\Application\Pages\Consultations\UseCase;

use App\Domain\Pages\Repository\ConsultationsRepositoryInterface;
use App\Domain\Pages\Repository\DeroulementConsultationRepositoryInterface;

final class GetAllConsultationsAndDeroulementUseCase
{
    public function __construct(private ConsultationsRepositoryInterface $consultationsRepositoryInterface, 
        private DeroulementConsultationRepositoryInterface $deroulementConsultationRepositoryInterface){}

    public function execute(): array
    {
        $consultations = $this->consultationsRepositoryInterface->getAllConsultations();
        $deroulement = $this->deroulementConsultationRepositoryInterface->getAllDeroulement();

        return [
            'consultations' => $consultations,
            'deroulement' => $deroulement,
        ];
    }
}