<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SaleLineRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SaleLineRepository::class)]
class SaleLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'saleLines')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?Sale $sale = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'saleLines')]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'saleLines')]
    private ?Service $service = null;

    #[ORM\ManyToOne(inversedBy: 'saleLines')]
    #[Assert\NotBlank]
    private ?TaxType $taxType = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?int $quantity = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Assert\NotBlank]
    private ?float $price = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Assert\NotBlank]
    private ?float $discount = null;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $maintenancePlan = false;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $total = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateAdd = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateUpd = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSale(): ?Sale
    {
        return $this->sale;
    }

    public function setSale(?Sale $sale): SaleLine
    {
        $this->sale = $sale;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): SaleLine
    {
        $this->title = $title;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): SaleLine
    {
        $this->product = $product;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): SaleLine
    {
        $this->service = $service;

        return $this;
    }

    public function getTaxType(): ?TaxType
    {
        return $this->taxType;
    }

    public function setTaxType(?TaxType $taxType): SaleLine
    {
        $this->taxType = $taxType;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): SaleLine
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): SaleLine
    {
        $this->price = $price;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): SaleLine
    {
        $this->discount = $discount;

        return $this;
    }

    public function isMaintenancePlan(): bool
    {
        return $this->maintenancePlan;
    }

    public function setMaintenancePlan(bool $maintenancePlan): SaleLine
    {
        $this->maintenancePlan = $maintenancePlan;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->dateAdd;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): SaleLine
    {
        $this->total = $total;

        return $this;
    }

    public function setDateAdd(\DateTimeInterface $dateAdd): SaleLine
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    public function getDateUpd(): ?\DateTimeInterface
    {
        return $this->dateUpd;
    }

    public function setDateUpd(?\DateTimeInterface $dateUpd): SaleLine
    {
        $this->dateUpd = $dateUpd;

        return $this;
    }
}
