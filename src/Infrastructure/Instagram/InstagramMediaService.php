<?php

namespace App\Infrastructure\Instagram;


use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Blog\Entity\InstagramPost;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class InstagramMediaService
{
    private HttpClientInterface $http;
    private InstagramTokenService $tokenService;
    private EntityManagerInterface $em;

    public function __construct(HttpClientInterface $http, InstagramTokenService $tokenService, EntityManagerInterface $em)
    {
        $this->http = $http;
        $this->tokenService = $tokenService;
        $this->em = $em;
    }

    /**
     * Synchronise les médias Instagram et les stocke en base de données.
     * @throws \RuntimeException
     * @return int
     */
    public function syncMedia(): int
    {
        $accessToken = $this->tokenService->getAccessToken();
        if (!$accessToken) {
            throw new \RuntimeException('Aucun token Instagram disponible.');
        }

        $endpoint = 'https://graph.instagram.com/me/media';
        $fields = 'id,caption,media_type,media_url,permalink,thumbnail_url,timestamp';
        $url = sprintf('%s?fields=%s&access_token=%s', $endpoint, $fields, $accessToken);

        $countNew = 0;
        $countUpdated = 0;

        while ($url) {
            $response = $this->http->request('GET', $url);
            $data = $response->toArray();

            foreach ($data['data'] as $item) {
                $existing = $this->em->getRepository(InstagramPost::class)
                    ->findOneBy(['instagramId' => $item['id']]);

                if (!$existing) {
                    // ✅ Nouveau post
                    $post = new InstagramPost();
                    $post->setInstagramId($item['id']);
                    $post->setCaption($item['caption'] ?? null);
                    $post->setMediaType($item['media_type']);
                    $post->setMediaUrl($item['media_url']);
                    $post->setPermalink($item['permalink']);
                    $post->setThumbnailUrl($item['thumbnail_url'] ?? null);
                    $post->setTimestamp(new \DateTime($item['timestamp']));
                    $this->em->persist($post);
                    $countNew++;
                } else {
                    // ♻️ Post déjà existant → mise à jour de l’URL (elle expire régulièrement)
                    $existing->setMediaUrl($item['media_url']);
                    $existing->setThumbnailUrl($item['thumbnail_url'] ?? null);
                    $existing->setCaption($item['caption'] ?? $existing->getCaption());
                    $existing->setPermalink($item['permalink']);
                    $countUpdated++;
                }
            }

            $this->em->flush();
            $url = $data['paging']['next'] ?? null;
        }

        return $countNew + $countUpdated;
    }

    public function getCarouselChildren(string $mediaId): array
    {
        $accessToken = $this->tokenService->getAccessToken();
        if (!$accessToken) {
            throw new \RuntimeException('Aucun token Instagram disponible.');
        }

        $url = sprintf('https://graph.instagram.com/%s/children?fields=id,media_type,media_url,thumbnail_url&access_token=%s', $mediaId, $accessToken);

        $response = $this->http->request('GET', $url);
        $data = $response->toArray();

        return $data['data'] ?? [];
    }

    public function refreshMediaUrlsIfExpired(): int
    {
        $accessToken = $this->tokenService->getAccessToken();
        if (!$accessToken) {
            throw new \RuntimeException('Aucun token Instagram disponible.');
        }

        $endpoint = 'https://graph.instagram.com/me/media';
        $fields = 'id,media_url,thumbnail_url,caption,permalink';
        $url = sprintf('%s?fields=%s&limit=100&access_token=%s', $endpoint, $fields, $accessToken);

        $response = $this->http->request('GET', $url);
        $data = $response->toArray();

        $updated = 0;

        foreach ($data['data'] as $item) {
            $existing = $this->em->getRepository(InstagramPost::class)
                ->findOneBy(['instagramId' => $item['id']]);

            if ($existing) {
                $existing->setMediaUrl($item['media_url']);
                $existing->setThumbnailUrl($item['thumbnail_url'] ?? null);
                $existing->setCaption($item['caption'] ?? $existing->getCaption());
                $existing->setPermalink($item['permalink']);
                $existing->setLastRefreshedAt(new \DateTimeImmutable());
                $updated++;
            }
        }

        $this->em->flush();

        return $updated;
    }
}
