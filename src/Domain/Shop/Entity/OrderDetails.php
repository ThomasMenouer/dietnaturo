<?php

namespace App\Domain\Shop\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Infrastructure\Persistence\Doctrine\Repository\Shop\OrderDetailsRepository;

#[ORM\Entity(repositoryClass: OrderDetailsRepository::class)]
class OrderDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private Orders $orders;

    #[ORM\Column(length: 255)]
    private string $productName;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private int $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrders(): Orders
    {
        return $this->orders;
    }

    public function setOrders(Orders $orders): static
    {
        $this->orders = $orders;

        return $this;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): static
    {
        $this->productName = $productName;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

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
}
