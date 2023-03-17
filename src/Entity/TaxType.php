<?php

namespace App\Entity;

use App\Repository\TaxTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TaxTypeRepository::class)]
class TaxType
{
    public const TAXT_TYPE_SUPEREDUCED_ID = 1;
    public const TAXT_TYPE_REDUCED_ID = 2;
    public const TAXT_TYPE_GENERAL_ID = 3;
    public const TAXT_TYPE_EXEMPT_ID = 4;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 60)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $rate = null;

    #[ORM\OneToMany(mappedBy: 'tax', targetEntity: Product::class)]
    private Collection $products;

    #[ORM\OneToMany(mappedBy: 'taxType', targetEntity: SaleLine::class)]
    private Collection $saleLines;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->saleLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): TaxType
    {
        $this->name = $name;

        return $this;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(float $rate): TaxType
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): TaxType
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setTax($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): TaxType
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getTax() === $this) {
                $product->setTax(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SaleLine>
     */
    public function getSaleLines(): Collection
    {
        return $this->saleLines;
    }

    public function addSaleLine(SaleLine $saleLine): TaxType
    {
        if (!$this->saleLines->contains($saleLine)) {
            $this->saleLines->add($saleLine);
            $saleLine->setTaxType($this);
        }

        return $this;
    }

    public function removeSaleLine(SaleLine $saleLine): TaxType
    {
        if ($this->saleLines->removeElement($saleLine)) {
            // set the owning side to null (unless already changed)
            if ($saleLine->getTaxType() === $this) {
                $saleLine->setTaxType(null);
            }
        }

        return $this;
    }
}
