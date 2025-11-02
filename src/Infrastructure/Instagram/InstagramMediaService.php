<?php

namespace App\Infrastructure\Instagram;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class InstagramMediaService
{
    private HttpClientInterface $http;
    private InstagramTokenService $tokenService;

    public function __construct(HttpClientInterface $http, InstagramTokenService $tokenService)
    {
        $this->http = $http;
        $this->tokenService = $tokenService;
    }

    public function getAllMedia(int $limit = 25): array
    {
        $accessToken = $this->tokenService->getAccessToken();
        if (!$accessToken) {
            throw new \RuntimeException('Aucun token Instagram disponible.');
        }

        $endpoint = 'https://graph.instagram.com/me/media';
        $fields = 'id,caption,media_type,media_url,permalink,thumbnail_url,timestamp';

        $results = [];
        $url = sprintf('%s?fields=%s&access_token=%s', $endpoint, $fields, $accessToken);

        while ($url && count($results) < $limit) {
            $response = $this->http->request('GET', $url);
            $data = $response->toArray();

            if (isset($data['data'])) {
                $results = array_merge($results, $data['data']);
            }

            $url = $data['paging']['next'] ?? null;
        }

        return array_slice($results, 0, $limit);
    }
}
