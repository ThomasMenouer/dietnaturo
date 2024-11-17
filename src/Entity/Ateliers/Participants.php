<?php

namespace App\Entity\Ateliers;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Ateliers\Ateliers;
use App\Repository\Ateliers\ParticipantsRepository;

#[ORM\Entity(repositoryClass: ParticipantsRepository::class)]
class Participants
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $email;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'participants')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Ateliers $ateliers = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getAteliers(): Ateliers
    {
        return $this->ateliers;
    }

    public function setAteliers(?Ateliers $ateliers): static
    {
        $this->ateliers = $ateliers;

        return $this;
    }

    #[ORM\PreRemove]
    public function preRemove()
    {
        // Détacher l'inscription de l'atelier avant suppression
        if ($this->ateliers) {
            $this->ateliers->removeParticipant($this);
        }
    }

    public function __toString(): string
    {
        return $this->email;
    }

        public function getFormattedDate(): string
    {
        return $this->date->format('d/m/Y H:i');
    }

}
