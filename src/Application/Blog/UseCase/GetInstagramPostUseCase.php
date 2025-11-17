<?php

namespace App\Application\Blog\UseCase;

use App\Domain\Blog\Entity\InstagramPost;
use App\Domain\Blog\Repository\InstagramPostRepositoryInterface;

class GetInstagramPostUseCase
{
    public function __construct(private InstagramPostRepositoryInterface $instagramPostRepositoryInterface) {}

    public function getInstagramPost(int $id): ?InstagramPost
    {
        return $this->instagramPostRepositoryInterface->getPostById($id);
    }

}
