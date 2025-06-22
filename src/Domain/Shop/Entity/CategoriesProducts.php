<?php

namespace App\Domain\Shop\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Domain\Shop\Entity\Products;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Infrastructure\Persistence\Doctrine\Repository\Shop\CategoriesProductsRepository;

#[ORM\Entity(repositoryClass: CategoriesProductsRepository::class)]
class CategoriesProducts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'products', targetEntity: Products::class)]
    private Collection $products;

    #[ORM\Column(length: 255)]
    private string $slug;

    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->products = new ArrayCollection();
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

        /**
     * @return Collection<int, Products>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addArticle(Products $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCategories($this);
        }

        return $this;
    }

    public function removeArticle(Products $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategories() === $this) {
                $product->setCategories(null);
            }
        }

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
}
