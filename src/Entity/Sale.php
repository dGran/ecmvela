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
    public const STATE_OVERPAYMENT = 'pago excedido';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'sales')]
    private ?Customer $customer = null;

    #[ORM\ManyToOne(inversedBy: 'sales')]
    private ?Pet $pet = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $totalDiscounts = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $totalWithoutTaxes = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $totalTaxes = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $total = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $declared = false;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $locked = false;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateNextBooking = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateAdd = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateUpd = null;

    #[ORM\OneToMany(mappedBy: 'sale', targetEntity: SaleLine::class)]
    private Collection $saleLines;

    #[ORM\OneToMany(mappedBy: 'sale', targetEntity: SalePayment::class)]
    private Collection $salePayments;

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

    public function setCustomer(?Customer $customer): Sale
    {
        $this->customer = $customer;

        return $this;
    }

    public function getPet(): ?Pet
    {
        return $this->pet;
    }

    public function setPet(?Pet $pet): Sale
    {
        $this->pet = $pet;

        return $this;
    }

    public function getTotalDiscounts(): ?float
    {
        return $this->totalDiscounts;
    }

    public function setTotalDiscounts(?float $totalDiscounts): Sale
    {
        $this->totalDiscounts = $totalDiscounts;

        return $this;
    }

    public function getTotalWithoutTaxes(): ?float
    {
        return $this->totalWithoutTaxes;
    }

    public function setTotalWithoutTaxes(?float $totalWithoutTaxes): Sale
    {
        $this->totalWithoutTaxes = $totalWithoutTaxes;

        return $this;
    }

    public function getTotalTaxes(): ?float
    {
        return $this->totalTaxes;
    }

    public function setTotalTaxes(?float $totalTaxes): Sale
    {
        $this->totalTaxes = $totalTaxes;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): Sale
    {
        $this->total = $total;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): Sale
    {
        $this->notes = $notes;

        return $this;
    }

    public function isDeclared(): bool
    {
        return $this->declared;
    }

    public function setDeclared(bool $declared): Sale
    {
        $this->declared = $declared;

        return $this;
    }

    public function isLocked(): bool
    {
        return $this->locked;
    }

    public function setLocked(bool $locked): Sale
    {
        $this->locked = $locked;

        return $this;
    }

    public function getDateNextBooking(): ?\DateTimeInterface
    {
        return $this->dateNextBooking;
    }

    public function setDateNextBooking(?\DateTimeInterface $dateNextBooking): Sale
    {
        $this->dateNextBooking = $dateNextBooking;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->dateAdd;
    }

    public function setDateAdd(\DateTimeInterface $dateAdd): Sale
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    public function getDateUpd(): ?\DateTimeInterface
    {
        return $this->dateUpd;
    }

    public function setDateUpd(?\DateTimeInterface $dateUpd): Sale
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

    public function addSaleLine(SaleLine $saleLine): Sale
    {
        if (!$this->saleLines->contains($saleLine)) {
            $this->saleLines->add($saleLine);
            $saleLine->setSale($this);
        }

        return $this;
    }

    public function removeSaleLine(SaleLine $saleLine): Sale
    {
        if ($this->saleLines->removeElement($saleLine)) {
            // set the owning side to null (unless already changed)
            if ($saleLine->getSale() === $this) {
                $saleLine->setSale(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SalePayment>
     */
    public function getSalePayments(): Collection
    {
        return $this->salePayments;
    }

    public function addSalePayment(SalePayment $salePayment): Sale
    {
        if (!$this->salePayments->contains($salePayment)) {
            $this->salePayments->add($salePayment);
            $salePayment->setSale($this);
        }

        return $this;
    }

    public function removeSalePayment(SalePayment $salePayment): Sale
    {
        if ($this->salePayments->removeElement($salePayment)) {
            // set the owning side to null (unless already changed)
            if ($salePayment->getSale() === $this) {
                $salePayment->setSale(null);
            }
        }

        return $this;
    }
}
