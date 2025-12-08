<?php

namespace App\Domain\Ateliers\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Domain\Ateliers\Entity\Participants;
use App\Domain\Ateliers\Enum\TypeAtelier;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Attribute as Vich;
use App\Infrastructure\Persistence\Doctrine\Repository\Ateliers\AteliersRepository;
use Doctrine\DBAL\Types\Type;

#[ORM\Entity(repositoryClass: AteliersRepository::class)]
#[Vich\Uploadable]
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

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: 'integer')]
    private int $price;

    #[ORM\Column(length: 255)]
    private string $slug;

    #[ORM\OneToMany(mappedBy: 'ateliers', targetEntity: Participants::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $participants;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $isAvailable = false;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $isVisio = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $link = null;

    #[ORM\Column(type: 'integer', options: ['default' => 5])]
    private int $places = 5;

    #[ORM\Column(type: "string", enumType: TypeAtelier::class)]
    private TypeAtelier $typeAtelier = TypeAtelier::ATELIER;


    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    #[Vich\UploadableField(mapping: 'ateliers', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): int
    {
        return $this->imageSize;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

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

    public function getIsAvailable(): bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): static
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getIsVisio(): bool
    {
        return $this->isVisio;
    }

    public function setIsVisio(bool $isVisio): static
    {
        $this->isVisio = $isVisio;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getPlaces(): int
    {
        return $this->places;
    }

    public function setPlaces(int $places): static
    {
        $this->places = $places;

        return $this;
    }

    public function getRemainingPlaces(): int
    {
        return $this->places - count($this->participants);
    }

    public function getTypeAtelier(): TypeAtelier
    {
        return $this->typeAtelier;
    }

    public function setTypeAtelier(TypeAtelier $typeAtelier): static
    {
        $this->typeAtelier = $typeAtelier;
        return $this;
    }


    // public function __tostring(): string
    // {
    //     return $this->date->format('d/m/Y H:i');
    // }

    public function getFormattedDate(): string
    {
        return $this->date->format('d/m/Y');
    }

    public function getFormattedDateHour(): string
    {
        return $this->date->format('H\hi');
    }
}
