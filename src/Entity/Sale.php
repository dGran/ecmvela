<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaleRepository::class)]
class Sale
{
    public const STATE_PAID = 'pagado';
    public const STATE_PARTIAL_PAYMENT = 'pago parcial';
    public const STATE_PENDING_PAYMENT = 'pago pendiente';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'sales')]
    private ?Customer $customer = null;

    #[ORM\ManyToOne(inversedBy: 'sales')]
    private ?Pet $pet = null;

    #[ORM\Column(nullable: true)]
    private ?float $discount = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    #[ORM\Column]
    private ?bool $manitenancePlan = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateNextBooking = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateAdd = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateUpd = null;

    #[ORM\OneToMany(mappedBy: 'sale', targetEntity: SaleLine::class)]
    private Collection $saleLines;

    public function __construct()
    {
        $this->salePayments = new ArrayCollection();
        $this->saleLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getPet(): ?Pet
    {
        return $this->pet;
    }

    public function setPet(?Pet $pet): self
    {
        $this->pet = $pet;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(?float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function isManitenancePlan(): ?bool
    {
        return $this->manitenancePlan;
    }

    public function setManitenancePlan(bool $manitenancePlan): self
    {
        $this->manitenancePlan = $manitenancePlan;

        return $this;
    }

    public function getDateNextBooking(): ?\DateTimeInterface
    {
        return $this->dateNextBooking;
    }

    public function setDateNextBooking(?\DateTimeInterface $dateNextBooking): self
    {
        $this->dateNextBooking = $dateNextBooking;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->dateAdd;
    }

    public function setDateAdd(\DateTimeInterface $dateAdd): self
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    public function getDateUpd(): ?\DateTimeInterface
    {
        return $this->dateUpd;
    }

    public function setDateUpd(?\DateTimeInterface $dateUpd): self
    {
        $this->dateUpd = $dateUpd;

        return $this;
    }

    /**
     * @return Collection<int, SaleLine>
     */
    public function getSaleLines(): Collection
    {
        return $this->saleLines;
    }

    public function addSaleLine(SaleLine $saleLine): self
    {
        if (!$this->saleLines->contains($saleLine)) {
            $this->saleLines->add($saleLine);
            $saleLine->setSale($this);
        }

        return $this;
    }

    public function removeSaleLine(SaleLine $saleLine): self
    {
        if ($this->saleLines->removeElement($saleLine)) {
            // set the owning side to null (unless already changed)
            if ($saleLine->getSale() === $this) {
                $saleLine->setSale(null);
            }
        }

        return $this;
    }
}