<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'services')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ServiceType $type = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: SaleLine::class)]
    private Collection $saleLines;

    public function __construct()
    {
        $this->saleLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?ServiceType
    {
        return $this->type;
    }

    public function setType(?ServiceType $type): Service
    {
        $this->type = $type;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): Service
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): Service
    {
        $this->price = $price;

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
            $saleLine->setService($this);
        }

        return $this;
    }

    public function removeSaleLine(SaleLine $saleLine): self
    {
        if ($this->saleLines->removeElement($saleLine)) {
            // set the owning side to null (unless already changed)
            if ($saleLine->getService() === $this) {
                $saleLine->setService(null);
            }
        }

        return $this;
    }
}
