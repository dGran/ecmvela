<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PetRepository::class)]
class Pet
{
    protected const PROFILE_TYPE_DOG_IMG_PATH = 'img/animals/dogs/';
    protected const DEFAULT_PROFILE_TYPE_DOG_IMG_PATH = 'img/animals/dogs/no-image.png';
    protected const PROFILE_TYPE_CAT_IMG_PATH = 'img/cats/';
    protected const DEFAULT_PROFILE_TYPE_CAT_IMG_PATH = 'img/animals/cats/no-image.png';
    protected const PROFILE_TYPE_RABBIT_IMG_PATH = 'img/rabbits/';
    protected const DEFAULT_PROFILE_TYPE_RABBIT_IMG_PATH = 'img/animals/rabbits/no-image.png';

    #[ORM\Id]
    #[ORM\GeneratedValue('AUTO')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 60)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'pets')]
    #[ORM\JoinColumn]
    private ?Customer $customer = null;

    #[ORM\ManyToOne(inversedBy: 'pets')]
    #[ORM\JoinColumn]
    private ?PetCategory $category = null;

    #[ORM\ManyToOne(inversedBy: 'pets')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Breed $breed = null;

    #[ORM\Column(length: 60, nullable: true)]
    #[Assert\Length(max: 60)]
    private ?string $color = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    private ?string $profileImg = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    private ?string $notes = null;

    #[ORM\Column]
    private bool $active = true;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateAdd = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateUpd = null;

    public function __construct()
    {
        $this->dateAdd = new \DateTime();
        $this->active = true;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Pet
    {
        $this->name = $name;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): Pet
    {
        $this->customer = $customer;

        return $this;
    }

    public function getCategory(): ?PetCategory
    {
        return $this->category;
    }

    public function setCategory(PetCategory $category): Pet
    {
        $this->category = $category;

        return $this;
    }

    public function getBreed(): ?Breed
    {
        return $this->breed;
    }

    public function setBreed(?Breed $breed): Pet
    {
        $this->breed = $breed;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): Pet
    {
        $this->color = $color;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function getProfileImg(): ?string
    {
        return $this->profileImg;
    }

    public function setProfileImg(?string $profileImg): Pet
    {
        $this->profileImg = $profileImg;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): void
    {
        $this->notes = $notes;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): Pet
    {
        $this->active = $active;

        return $this;
    }

    public function getDateAdd(): \DateTimeInterface
    {
        return $this->dateAdd;
    }

    public function setDateAdd(\DateTimeInterface $dateAdd): Pet
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    public function getDateUpd(): ?\DateTimeInterface
    {
        return $this->dateUpd;
    }

    public function setDateUpd(\DateTimeInterface $dateUpd): Pet
    {
        $this->dateUpd = $dateUpd;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getProfileImgPath(): ?string
    {
        if ($this->profileImg) {
            return self::PROFILE_TYPE_DOG_IMG_PATH.$this->profileImg;
        }

        return self::DEFAULT_PROFILE_TYPE_DOG_IMG_PATH;
    }

    public function getAnimalYears(): ?string
    {
        if (!$this->active) {
            if ($this->birthDate !== null) {
                return date_format($this->birthDate, "d/m/Y");;
            }

            return null;
        }

        $age = null;

        if ($this->birthDate !== null) {
            $currentDate = new \DateTime();
            $difference = $currentDate->diff($this->birthDate);

            if ($difference->y) { $age .= $difference->format("%y años"); }
            if ($difference->m) { $age .= $difference->format(", %m meses"); }
            if ($difference->d) { $age .= $difference->format(" y %d días"); }
        }

        return $age;
    }
}