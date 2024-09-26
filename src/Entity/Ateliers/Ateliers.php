<?php

namespace App\Entity\Ateliers;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Ateliers\Participants;
use App\Entity\Ateliers\DatesAteliers;
use Doctrine\Common\Collections\Collection;
use App\Repository\Ateliers\AteliersRepository;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: AteliersRepository::class)]
class Ateliers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(length: 255)]
    private string $theme;

    #[ORM\Column(type: Types::TEXT)]
    private string $content;

    #[ORM\Column(length: 255)]
    private string $slug;

    #[ORM\OneToMany(mappedBy: 'ateliers', targetEntity: Participants::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $participants;

    #[ORM\OneToMany(mappedBy: 'ateliers', targetEntity: DatesAteliers::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $datesDisponibles;

    #[ORM\Column]
    private ?bool $isAvailable = null;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->datesDisponibles = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTheme(): string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): static
    {
        $this->theme = $theme;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Participants>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participants $participants): static
    {
        if (!$this->participants->contains($participants)) {
            $this->participants->add($participants);
            $participants->setAteliers($this);
        }

        return $this;
    }

    public function removeParticipant(Participants $participants): static
    {
        if ($this->participants->removeElement($participants)) {
            // set the owning side to null (unless already changed)
            if ($participants->getAteliers() === $this) {
                $participants->setAteliers(null);
            }
        }

        return $this;
    }

    public function isIsAvailable(): bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): static
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    /**
     * @return Collection<int, DatesAteliers>
     */
    public function getDatesDisponibles(): Collection
    {
        return $this->datesDisponibles;
    }

    public function addDatesDisponible(DatesAteliers $datesDisponibles): static
    {
        if (!$this->datesDisponibles->contains($datesDisponibles)) {
            $this->datesDisponibles->add($datesDisponibles);
            $datesDisponibles->setAtelier($this);
        }

        return $this;
    }

    public function removeDatesDisponible(DatesAteliers $datesDisponibles): static
    {
        if ($this->datesDisponibles->removeElement($datesDisponibles)) {
            // set the owning side to null (unless already changed)
            if ($datesDisponibles->getAtelier() === $this) {
                $datesDisponibles->setAtelier(null);
            }
        }

        return $this;
    }
}
