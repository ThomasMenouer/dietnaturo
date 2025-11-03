<?php

namespace App\Application\Blog\UseCase;

use App\Domain\Blog\Entity\InstagramPost;
use App\Domain\Blog\Repository\InstagramPostRepositoryInterface;
use App\Infrastructure\Instagram\InstagramMediaService;

class GetInstagramPostWithChildrenUseCase
{
    public function __construct(
        private InstagramPostRepositoryInterface $repository,
        private InstagramMediaService $instagramMediaService
    ) {}

    public function execute(int $id): ?array
    {
        $post = $this->repository->getPostById($id);
        if (!$post) {
            return null;
        }

        $children = [];
        if ($post->getMediaType() === 'CAROUSEL_ALBUM') {
            $children = $this->instagramMediaService->getCarouselChildren($post->getInstagramId());
        }

        return [
            'post' => $post,
            'children' => $children,
        ];
    }
}
