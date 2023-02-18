<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BreedRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BreedRepository::class)]
class Breed
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    private string $name;

    #[ORM\ManyToOne(inversedBy: 'breeds')]
    #[ORM\JoinColumn(nullable: true)]
    private ?PetCategory $petCategory = null;

    #[ORM\ManyToOne(inversedBy: 'breeds')]
    #[ORM\JoinColumn(nullable: true)]
    private ?DogSize $dogSize = null;

    #[ORM\ManyToOne(inversedBy: 'breeds')]
    #[ORM\JoinColumn(nullable: true)]
    private ?HairType $hairType = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $hairSize = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img = null;

    #[ORM\Column(length: 120, nullable: true)]
    private string $slug;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateAdd = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateUpd = null;

    #[ORM\OneToMany(mappedBy: 'breed', targetEntity: Pet::class)]
    private Collection $pets;

    public function __construct()
    {
        $this->dateAdd = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Breed
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Breed
    {
        $this->name = $name;

        return $this;
    }

    public function getPetCategory(): ?PetCategory
    {
        return $this->petCategory;
    }

    public function setPetCategory(?PetCategory $petCategory): Breed
    {
        $this->petCategory = $petCategory;

        return $this;
    }

    public function getDogSize(): ?DogSize
    {
        return $this->dogSize;
    }

    public function setDogSize(?DogSize $dogSize): Breed
    {
        $this->dogSize = $dogSize;

        return $this;
    }

    public function getHairType(): ?HairType
    {
        return $this->hairType;
    }

    public function setHairType(?HairType $hairType): Breed
    {
        $this->hairType = $hairType;

        return $this;
    }

    public function getHairSize(): ?string
    {
        return $this->hairSize;
    }

    public function setHairSize(?string $hairSize): Breed
    {
        $this->hairSize = $hairSize;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): Breed
    {
        $this->img = $img;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): Breed
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDateAdd(): \DateTimeInterface
    {
        return $this->dateAdd;
    }

    public function setDateAdd(\DateTimeInterface $dateAdd): Breed
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    public function getDateUpd(): ?\DateTimeInterface
    {
        return $this->dateUpd;
    }

    public function setDateUpd(\DateTimeInterface $dateUpd): Breed
    {
        $this->dateUpd = $dateUpd;

        return $this;
    }

    public function getPets(): Collection
    {
        return $this->pets;
    }

    public function setPets(Collection $pets): Breed
    {
        $this->pets = $pets;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
