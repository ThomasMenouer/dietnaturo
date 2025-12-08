<?php


namespace App\Application\Blog\UseCase;

use App\Domain\Blog\Repository\InstagramPostRepositoryInterface;


final class GetInstagramPostLastRefreshUseCase
{
    public function __construct(private InstagramPostRepositoryInterface $repository)
    {
    }

    public function execute(): ?\DateTimeImmutable
    {
        return $this->repository->getLastRefreshedAt();
    }

}

