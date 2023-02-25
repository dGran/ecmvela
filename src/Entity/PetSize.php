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

    #[ORM\Column(length: 60)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $minWeight = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxWeight = null;

    #[ORM\Column(length: 120)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateAdd = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateUpd = null;

    #[ORM\OneToMany(mappedBy: 'dogSize', targetEntity: Breed::class)]
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): PetSize
    {
        $this->name = $name;

        return $this;
    }

    public function getMinWeight(): ?int
    {
        return $this->minWeight;
    }

    public function setMinWeight(?int $minWeight): PetSize
    {
        $this->minWeight = $minWeight;

        return $this;
    }

    public function getMaxWeight(): ?int
    {
        return $this->maxWeight;
    }

    public function setMaxWeight(?int $maxWeight): PetSize
    {
        $this->maxWeight = $maxWeight;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): PetSize
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDateAdd(): \DateTimeInterface
    {
        return $this->dateAdd;
    }

    public function setDateAdd(\DateTimeInterface $dateAdd): PetSize
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    public function getDateUpd(): ?\DateTimeInterface
    {
        return $this->dateUpd;
    }

    public function setDateUpd(\DateTimeInterface $dateUpd): PetSize
    {
        $this->dateUpd = $dateUpd;

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