<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PetSizeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PetSizeRepository::class)]
class PetSize
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'petSizes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?PetCategory $category = null;

    #[ORM\Column(length: 60)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?float $minWeight = null;

    #[ORM\Column(nullable: true)]
    private ?float $maxWeight = null;

    #[ORM\OneToMany(mappedBy: 'petSize', targetEntity: Breed::class)]
    private Collection $breeds;

    public function __construct()
    {
        $this->breeds = new ArrayCollection();
        $this->dateAdd = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(?int $id): PetSize
    {
        $this->id = $id;

        return $this;
    }

    public function getCategory(): ?PetCategory
    {
        return $this->category;

    }

    public function setCategory(?PetCategory $category): PetSize
    {
        $this->category = $category;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): PetSize
    {
        $this->name = $name;

        return $this;
    }

    public function getMinWeight(): ?float
    {
        return $this->minWeight;
    }

    public function setMinWeight(?float $minWeight): PetSize
    {
        $this->minWeight = $minWeight;

        return $this;
    }

    public function getMaxWeight(): ?float
    {
        return $this->maxWeight;
    }

    public function setMaxWeight(?float $maxWeight): PetSize
    {
        $this->maxWeight = $maxWeight;

        return $this;
    }

    /**
     * @return Collection<int, Breed>
     */
    public function getBreeds(): Collection
    {
        return $this->breeds;
    }

    public function addBreed(Breed $breed): PetSize
    {
        if (!$this->breeds->contains($breed)) {
            $this->breeds->add($breed);
            $breed->setPetSize($this);
        }

        return $this;
    }

    public function removeBreed(Breed $breed): PetSize
    {
        if ($this->breeds->removeElement($breed) && $breed->getPetSize() === $this) {
            $breed->setPetSize(null);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}