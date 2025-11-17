<?php

namespace App\Application\Blog\UseCase;

use App\Application\Port\Out\InstagramTokenPort;

class RefreshInstagramTokenUseCase
{
    public function __construct(private InstagramTokenPort $instagramTokenService) {}

    public function execute(): bool
    {
        $token = $this->instagramTokenService->refreshLongLivedToken();
        return $token !== null;
    }
}
