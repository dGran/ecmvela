<?php

declare(strict_types=1);

namespace App\Model\Report;

use App\Entity\Customer;
use App\Entity\Pet;

class Sale
{
    private int $id;

    private \DateTime $date;

    private float $total;

    private ?Pet $pet = null;

    private ?Customer $customer = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Sale
    {
        $this->id = $id;

        return $this;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): Sale
    {
        $this->date = $date;

        return $this;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): Sale
    {
        $this->total = $total;

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

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): Sale
    {
        $this->customer = $customer;

        return $this;
    }
}