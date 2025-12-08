<?php

namespace App\Domain\Pages\Entity\Accompagnement;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Pages\Entity\Accompagnement\AccompagnementContent;
use App\Infrastructure\Persistence\Doctrine\Repository\Pages\Accompagnement\AccompagnementRepository;

#[ORM\Entity(repositoryClass: AccompagnementRepository::class)]
class Accompagnement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private string $slug;

    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    private int $pagePosition= 0;

    #[ORM\OneToMany(mappedBy: 'accompagnement', targetEntity: AccompagnementContent::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $contents;

    public function __construct()
    {
        $this->contents = new ArrayCollection();
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

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;
        return $this;
    }

    public function getPagePosition(): int
    {
        return $this->pagePosition;
    }

    public function setPagePosition(int $pagePosition): static
    {
        $this->pagePosition = $pagePosition;
        return $this;
    }

    /** @return Collection<int, AccompagnementContent> */
    public function getContents(): Collection
    {
        return $this->contents;
    }

    public function addContent(AccompagnementContent $content): static
    {
        if (!$this->contents->contains($content)) {
            $this->contents[] = $content;
            $content->setAccompagnement($this);
        }
        return $this;
    }

    public function removeContent(AccompagnementContent $content): static
    {
        if ($this->contents->removeElement($content)) {
            if ($content->getAccompagnement() === $this) {
                $content->setAccompagnement(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->getTitle();
    }
}
