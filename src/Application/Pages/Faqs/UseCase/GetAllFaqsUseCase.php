<?php

namespace App\Application\Pages\Faqs\UseCase;

use App\Domain\Pages\Repository\FaqsRepositoryInterface;



final class GetAllFaqsUseCase
{
    public function __construct(private FaqsRepositoryInterface $faqsRepository)
    {
        $this->faqsRepository = $faqsRepository;
    }

    public function execute(): array
    {
        return $this->faqsRepository->getAllFaqs();
    }
}