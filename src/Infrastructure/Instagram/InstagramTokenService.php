<?php

namespace App\Infrastructure\Instagram;

use App\Application\Port\Out\InstagramTokenPort;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class InstagramTokenService implements InstagramTokenPort
{
    private string $appSecret;
    private string $storagePath;
    private HttpClientInterface $http;

    public function __construct(HttpClientInterface $http, string $instagramAppSecret)
    {
        $this->http = $http;
        $this->appSecret = $instagramAppSecret;
        $this->storagePath = __DIR__ . '/../../../var/instagram_token.json';
    }

    public function getAccessToken(): ?string
    {
        if (!file_exists($this->storagePath)) {
            return null;
        }

        $data = json_decode(file_get_contents($this->storagePath), true);

        // Si le token est proche de l'expiration (< 5 jours), on le rafraîchit
        if (isset($data['expires_at']) && $data['expires_at'] - time() < 5 * 24 * 60 * 60) {
            return $this->refreshLongLivedToken();
        }

        return $data['access_token'] ?? null;
    }

    public function storeTokenManually(string $token, int $expiresIn): void
    {
        $this->saveAccessToken($token, $expiresIn);
    }

    private function saveAccessToken(string $token, int $expiresIn): void
    {
        $data = [
            'access_token' => $token,
            'expires_at' => time() + $expiresIn,
        ];
        file_put_contents($this->storagePath, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function exchangeShortLivedToken(string $shortLivedToken): ?string
    {
        $url = sprintf(
            'https://graph.instagram.com/access_token?grant_type=ig_exchange_token&client_secret=%s&access_token=%s',
            $this->appSecret,
            $shortLivedToken
        );

        $response = $this->http->request('GET', $url);
        $data = $response->toArray();

        if (isset($data['access_token'])) {
            $this->saveAccessToken($data['access_token'], $data['expires_in']);
            return $data['access_token'];
        }

        return null;
    }

    public function refreshLongLivedToken(): ?string
    {
        $token = $this->getRawToken();
        if (!$token) {
            return null;
        }

        $url = sprintf(
            'https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=%s',
            $token
        );

        $response = $this->http->request('GET', $url);
        $data = $response->toArray();

        if (isset($data['access_token'])) {
            $this->saveAccessToken($data['access_token'], $data['expires_in']);
            return $data['access_token'];
        }

        return null;
    }

    // Récupère le token sans déclencher le refresh automatique
    private function getRawToken(): ?string
    {
        if (!file_exists($this->storagePath)) {
            return null;
        }

        $data = json_decode(file_get_contents($this->storagePath), true);
        return $data['access_token'] ?? null;
    }
}
