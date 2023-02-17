<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AnimalTypeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalTypeRepository::class)]
class AnimalType
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

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Animal::class)]
    private Collection $animals;

    #[ORM\OneToMany(mappedBy: 'animalType', targetEntity: Breed::class)]
    private Collection $breeds;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): AnimalType
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    /**
     * @param Collection $animals
     * @return AnimalType
     */
    public function setAnimals(Collection $animals): AnimalType
    {
        $this->animals = $animals;

        return $this;
    }

    public function getBreeds(): Collection
    {
        return $this->breeds;
    }

    public function setBreeds(Collection $breeds): AnimalType
    {
        $this->breeds = $breeds;

        return $this;
    }
}
