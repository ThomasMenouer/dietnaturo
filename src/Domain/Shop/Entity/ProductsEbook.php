<?php

namespace App\Domain\Shop\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Attribute as Vich;


#[ORM\Entity]
#[Vich\Uploadable]
class ProductsEbook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(inversedBy: 'ebooks')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Products $product;

    #[Vich\UploadableField(mapping: 'product_ebooks', fileNameProperty: 'fileName', size: 'fileSize')]
    private ?File $file = null;

    #[ORM\Column(nullable: true)]
    private ?string $fileName = null;

    #[ORM\Column(nullable: true)]
    private ?int $fileSize = null;

    #[ORM\Column(type: 'string', length: 10)]
    private string $format = 'pdf';

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function setFile(?File $file = null): void
    {
        $this->file = $file;

        if ($file !== null) {
            $this->updatedAt = new \DateTimeImmutable();
            
            if ($file instanceof UploadedFile) {
                $this->fileName = $file->getClientOriginalName();
            }
        }
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProduct(): Products
    {
        return $this->product;
    }

    public function setProduct(Products $product): static
    {
        $this->product = $product;
        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): void
    {
        $this->fileName = $fileName;
    }

    public function getFileSize(): int
    {
        return $this->fileSize;
    }

    public function setFileSize(?int $fileSize): void
    {
        $this->fileSize = $fileSize;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function setFormat(string $format): static
    {
        $this->format = $format;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
