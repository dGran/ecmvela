<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AnimalTypeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalTypeRepository::class)]
class PetCategory
{
    protected const TYPE_DOG_ID = 1;
    protected const TYPE_CAT_ID = 2;
    protected const TYPE_RABBIT_ID = 3;

    protected const TYPE_DOG_NAME = 'Perro';
    protected const TYPE_CAT_NAME = 'Gato';
    protected const TYPE_RABBIT_NAME = 'Conejo';

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
}
