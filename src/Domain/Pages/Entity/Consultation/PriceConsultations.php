<?php

namespace App\Domain\Pages\Entity\Consultation;


use Doctrine\ORM\Mapping as ORM;
use App\Infrastructure\Persistence\Doctrine\Repository\Pages\Consultation\PriceConsultationsRepository;


#[ORM\Entity(repositoryClass: PriceConsultationsRepository::class)]
class PriceConsultations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 100)]
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

     #[ORM\Column(length: 100, nullable: true)]
    private ?string $category = null;

    #[ORM\Column]
    private int $price;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }
    public function setCategory(?string $category): static
    {
        $this->category = $category;
        return $this;
    }
}
