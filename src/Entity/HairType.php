<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\HairTypeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HairTypeRepository::class)]
class HairType
{
    #[ORM\Id]
    #[ORM\GeneratedValue('AUTO')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'hairType', targetEntity: Breed::class)]
    private Collection $breeds;

    public function __construct()
    {
        $this->dateAdd = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): HairType
    {
        $this->name = $name;

        return $this;
    }

    public function getDateAdd(): \DateTime
    {
        return $this->dateAdd;
    }

    public function setDateAdd(\DateTime $dateAdd): void
    {
        $this->dateAdd = $dateAdd;
    }

    /**
     * @return Collection<int, Breed>|null
     */
    public function getBreeds(): ?Collection
    {
        return $this->breeds;
    }

    public function addBreed(Breed $breed): HairType
    {
        if (!$this->breeds->contains($breed)) {
            $this->breeds->add($breed);
            $breed->setHairType($this);
        }

        return $this;
    }

    public function removeBreed(Breed $breed): HairType
    {
        if ($this->breeds->removeElement($breed) && $breed->getHairType() === $this) {
            $breed->setHairType(null);
        }

        return $this;
    }
}
