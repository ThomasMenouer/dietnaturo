<?php

namespace App\Entity\Ateliers;

use App\Entity\Ateliers\Ateliers;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\Ateliers\DatesAteliersRepository;

#[ORM\Entity(repositoryClass: DatesAteliersRepository::class)]
class DatesAteliers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(targetEntity: Ateliers::class, inversedBy: 'datesDisponibles')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Ateliers $ateliers = null;

    #[ORM\OneToMany(mappedBy: 'dateDisponible', targetEntity: Participants::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $participants;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getAtelier(): ?Ateliers
    {
        return $this->ateliers;
    }

    public function setAtelier(?Ateliers $ateliers): static
    {
        $this->ateliers = $ateliers;

        return $this;
    }

    // public function __toString(): string
    // {
    //     return $this->getDate()->format('d/m/Y H:i'); 
    // }

    public function __tostring(): string
    {
        return $this->date->format('d/m/Y H:i');
    }
    
}