<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PetCategoryRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PetCategoryRepository::class)]
class PetCategory
{
    public const TYPE_DOG_ID = 1;
    public const TYPE_CAT_ID = 2;
    public const TYPE_RABBIT_ID = 3;

    public const TYPE_DOG_NAME = 'Perro';
    public const TYPE_CAT_NAME = 'Gato';
    public const TYPE_RABBIT_NAME = 'Conejo';

    #[ORM\Id]
    #[ORM\GeneratedValue('NONE')]
    #[ORM\Column]
    private ?int $id = self::TYPE_DOG_ID;

    #[ORM\Column(length: 60)]
    private ?string $name = self::TYPE_DOG_NAME;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Pet::class)]
    private Collection $pets;

    #[ORM\OneToMany(mappedBy: 'petCategory', targetEntity: Breed::class)]
    private Collection $breeds;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: PetSize::class)]
    private Collection $petSizes;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): PetCategory
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getPets(): Collection
    {
        return $this->pets;
    }

    /**
     * @param Collection $pets
     * @return PetCategory
     */
    public function setPets(Collection $pets): PetCategory
    {
        $this->pets = $pets;

        return $this;
    }

    public function getBreeds(): Collection
    {
        return $this->breeds;
    }

    public function setBreeds(Collection $breeds): PetCategory
    {
        $this->breeds = $breeds;

        return $this;
    }

    public function getPetSizes(): Collection
    {
        return $this->petSizes;
    }

    public function setPetSizes(Collection $petSizes): PetCategory
    {
        $this->petSizes = $petSizes;

        return $this;
    }
}
