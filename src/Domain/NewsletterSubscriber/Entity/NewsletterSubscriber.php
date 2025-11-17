<?php

namespace App\Domain\NewsletterSubscriber\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class NewsletterSubscriber
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private string $email;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $subscribedAt;

    #[ORM\Column(length: 64, unique: true)]
    private string $unsubscribeToken;

    public function __construct(string $email)
    {
        $this->email = $email;
        $this->subscribedAt = new \DateTimeImmutable();
        $this->unsubscribeToken = bin2hex(random_bytes(32));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSubscribedAt(): \DateTimeInterface
    {
        return $this->subscribedAt;
    }

    public function getUnsubscribeToken(): string
    {
        return $this->unsubscribeToken;
    }
}
