<?php

namespace App\Entity;

use App\Repository\DogSizeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DogSizeRepository::class)]
class DogSize
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

    #[ORM\Column(length: 120, nullable: true)]
    private string $slug;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateAdd = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateUpd = null;

    #[ORM\OneToMany(mappedBy: 'dogSize', targetEntity: Breed::class)]
    private Collection $breeds;

    public function __construct()
    {
        $this->breed2s = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): DogSize
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): DogSize
    {
        $this->name = $name;

        return $this;
    }

    public function getMinWeight(): ?int
    {
        return $this->minWeight;
    }

    public function setMinWeight(?int $minWeight): DogSize
    {
        $this->minWeight = $minWeight;

        return $this;
    }

    public function getMaxWeight(): ?int
    {
        return $this->maxWeight;
    }

    public function setMaxWeight(?int $maxWeight): DogSize
    {
        $this->maxWeight = $maxWeight;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->dateAdd;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): DogSize
    {
        $this->slug = $slug;

        return $this;
    }

    public function setDateAdd(?\DateTimeInterface $dateAdd): DogSize
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    public function getDateUpd(): ?\DateTimeInterface
    {
        return $this->dateUpd;
    }

    public function setDateUpd(?\DateTimeInterface $dateUpd): DogSize
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

    public function addBreed(Breed $breed): DogSize
    {
        if (!$this->breeds->contains($breed)) {
            $this->breeds->add($breed);
            $breed->setDogSize($this);
        }

        return $this;
    }

    public function removeBreed(Breed $breed): DogSize
    {
        if ($this->breeds->removeElement($breed) && $breed->getDogSize() === $this) {
            $breed->setDogSize(null);
        }

        return $this;
    }
}