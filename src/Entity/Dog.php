<?php

namespace App\Entity;

use App\Repository\DogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DogRepository::class)]
class Dog
{
    protected const PROFILE_IMG_PATH = 'img/dogs/';
    protected const DEFAULT_PROFILE_IMG_PATH = 'img/dogs/no-image.png';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'dogs')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Breed $breed = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profileImg = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $notes = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $ownerName = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $ownerPhone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ownerEmail = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $ownerLocation = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $ownerAddress = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $ownerCP = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $ownerIdentification = null;

    #[ORM\Column]
    private bool $active = true;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $dateAdd;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateUpd = null;

    public function __construct()
    {
        $this->dateAdd = new \DateTime();
        $this->active = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): Dog
    {
        $this->name = $name;

        return $this;
    }

    public function getBreed(): ?Breed
    {
        return $this->breed;
    }

    public function setBreed(?Breed $breed): Dog
    {
        $this->breed = $breed;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): Dog
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

    public function setProfileImg(?string $profileImg): Dog
    {
        $this->profileImg = $profileImg;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @param string|null $notes
     */
    public function setNotes(?string $notes): void
    {
        $this->notes = $notes;
    }

    public function getOwnerName(): ?string
    {
        return $this->ownerName;
    }

    public function setOwnerName(string $ownerName): Dog
    {
        $this->ownerName = $ownerName;

        return $this;
    }

    public function getOwnerPhone(): ?string
    {
        return $this->ownerPhone;
    }

    public function setOwnerPhone(?string $ownerPhone): Dog
    {
        $this->ownerPhone = $ownerPhone;

        return $this;
    }

    public function getOwnerEmail(): ?string
    {
        return $this->ownerEmail;
    }

    public function setOwnerEmail(?string $ownerEmail): Dog
    {
        $this->ownerEmail = $ownerEmail;

        return $this;
    }

    public function getOwnerLocation(): ?string
    {
        return $this->ownerLocation;
    }

    public function setOwnerLocation(?string $ownerLocation): Dog
    {
        $this->ownerLocation = $ownerLocation;

        return $this;
    }

    public function getOwnerAddress(): ?string
    {
        return $this->ownerAddress;
    }

    public function setOwnerAddress(?string $ownerAddress): Dog
    {
        $this->ownerAddress = $ownerAddress;

        return $this;
    }

    public function getOwnerCP(): ?string
    {
        return $this->ownerCP;
    }

    public function setOwnerCP(?string $ownerCP): Dog
    {
        $this->ownerCP = $ownerCP;

        return $this;
    }

    public function getOwnerIdentification(): ?string
    {
        return $this->ownerIdentification;
    }

    public function setOwnerIdentification(?string $ownerIdentification): Dog
    {
        $this->ownerIdentification = $ownerIdentification;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): Dog
    {
        $this->active = $active;

        return $this;
    }

    public function getDateAdd(): \DateTimeInterface
    {
        return $this->dateAdd;
    }

    public function setDateAdd(\DateTimeInterface $dateAdd): Dog
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    public function getDateUpd(): ?\DateTimeInterface
    {
        return $this->dateUpd;
    }

    public function setDateUpd(?\DateTimeInterface $dateUpd): Dog
    {
        $this->dateUpd = $dateUpd;

        return $this;
    }

    public function getProfileImgPath(): ?string
    {
        if ($this->profileImg) {
            return self::PROFILE_IMG_PATH.$this->profileImg;
        }

        return self::DEFAULT_PROFILE_IMG_PATH;
    }

    public function getDogYears(): ?string
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
