<?php

namespace App\Domain\Shop\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Infrastructure\Persistence\Doctrine\Repository\Shop\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
class Products
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    #[ORM\Column]
    private int $price;

    #[ORM\Column(length: 255)]
    private string $slug;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private CategoriesProducts $categories;

    #[ORM\Column(type: 'boolean')]
    private bool $enabled = true;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductsCover::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $covers;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductsEbook::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $ebooks;

    public function __construct()
    {
        $this->covers = new ArrayCollection();
        $this->ebooks = new ArrayCollection();
    }

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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
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

    public function getCategories(): CategoriesProducts
    {
        return $this->categories;
    }

    public function setCategories(CategoriesProducts $categories): static
    {
        $this->categories = $categories;
        return $this;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): static
    {
        $this->enabled = $enabled;
        return $this;
    }

    /** @return Collection<int, ProductsCover> */
    public function getCovers(): Collection
    {
        return $this->covers;
    }

    public function getProductsCover(): ?ProductsCover
    {
        return $this->covers->first()  ?: null;
    }

    public function addCover(ProductsCover $cover): static
    {
        if (!$this->covers->contains($cover)) {
            $this->covers[] = $cover;
            $cover->setProduct($this);
        }

        return $this;
    }

    public function removeCover(ProductsCover $cover): static
    {
        if ($this->covers->removeElement($cover)) {
            if ($cover->getProduct() === $this) {
                $cover->setProduct(null);
            }
        }

        return $this;
    }

    /** @return Collection<int, ProductsEbook> */
    public function getEbooks(): Collection
    {
        return $this->ebooks;
    }

    public function addEbook(ProductsEbook $ebook): static
    {
        if (!$this->ebooks->contains($ebook)) {
            $this->ebooks[] = $ebook;
            $ebook->setProduct($this);
        }

        return $this;
    }

    public function removeEbook(ProductsEbook $ebook): static
    {
        if ($this->ebooks->removeElement($ebook)) {
            if ($ebook->getProduct() === $this) {
                $ebook->setProduct(null);
            }
        }

        return $this;
    }

    public function getImagePath(): string
    {
        $cover = $this->getProductsCover();

        return $cover && $cover->getImageName()
            ? '/images/products/covers/' . $cover->getImageName()
            : '/images/products/default.jpg';
    }
}
