<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PaymentMethodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PaymentMethodRepository::class)]
class PaymentMethod
{
    public const CASH_METHOD_ID = 1;
    public const BIZUM_METHOD_ID = 2;
    public const CARD_METHOD_ID = 3;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 60)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'paymentMethod', targetEntity: SalePayment::class)]
    private Collection $salePayments;

    public function __construct()
    {
        $this->sales = new ArrayCollection();
        $this->salePayments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): PaymentMethod
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, SalePayment>
     */
    public function getSalePayments(): Collection
    {
        return $this->salePayments;
    }

    public function addSalePayment(SalePayment $salePayment): PaymentMethod
    {
        if (!$this->salePayments->contains($salePayment)) {
            $this->salePayments->add($salePayment);
            $salePayment->setPaymentMethod($this);
        }

        return $this;
    }

    public function removeSalePayment(SalePayment $salePayment): PaymentMethod
    {
        if ($this->salePayments->removeElement($salePayment)) {
            // set the owning side to null (unless already changed)
            if ($salePayment->getPaymentMethod() === $this) {
                $salePayment->setPaymentMethod(null);
            }
        }

        return $this;
    }
}
