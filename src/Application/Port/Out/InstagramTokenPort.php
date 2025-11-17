<?php

namespace App\Application\Port\Out;

interface InstagramTokenPort
{
    public function getAccessToken(): ?string;

    public function exchangeShortLivedToken(string $shortLivedToken): ?string;

    public function refreshLongLivedToken(): ?string;
}
