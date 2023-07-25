<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SalePaymentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SalePaymentRepository::class)]
class SalePayment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'salePayments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?Sale $sale = null;

    #[ORM\ManyToOne(inversedBy: 'salePayments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?PaymentMethod $paymentMethod = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?float $amount = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateAdd = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSale(): ?Sale
    {
        return $this->sale;
    }

    public function setSale(?Sale $sale): SalePayment
    {
        $this->sale = $sale;

        return $this;
    }

    public function getPaymentMethod(): ?PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?PaymentMethod $paymentMethod): SalePayment
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): SalePayment
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->dateAdd;
    }

    public function setDateAdd(\DateTimeInterface $dateAdd): SalePayment
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }
}
