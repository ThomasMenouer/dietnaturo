<?php


namespace App\Application\Pages\Consultations\UseCase;

use App\Domain\Pages\Repository\PriceConsultationsRepositoryInterface;

final class GetAllPriceConsultationsUseCase
{
    public function __construct(
        private readonly PriceConsultationsRepositoryInterface $priceConsultationRepository
    ) {}

    public function execute(): array
    {
        return $this->priceConsultationRepository->getPriceConsultations();
    }
}