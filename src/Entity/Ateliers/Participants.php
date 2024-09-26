<?php

namespace App\Entity\Ateliers;

use App\Entity\Ateliers\Ateliers;
use App\Repository\Ateliers\ParticipantsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipantsRepository::class)]
class Participants
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'participants')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Ateliers $ateliers = null;


    #[ORM\ManyToOne(targetEntity: DatesAteliers::class, inversedBy: 'participants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DatesAteliers $dateDisponible = null;

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

    public function getAteliers(): Ateliers
    {
        return $this->ateliers;
    }

    public function setAteliers(?Ateliers $ateliers): static
    {
        $this->ateliers = $ateliers;

        return $this;
    }

    public function getDateDisponible(): ?DatesAteliers
    {
        return $this->dateDisponible;
    }

    public function setDateDisponible(?DatesAteliers $dateDisponible): self
    {
        $this->dateDisponible = $dateDisponible;

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

}
