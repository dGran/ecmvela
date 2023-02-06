<?php

namespace App\Entity;

use App\Repository\DogRepository;
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

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $breed = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(length: 60)]
    private ?string $ownerName = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $ownerPhone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ownerEmail = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $ownerLocation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profileImg = null;

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

    public function getBreed(): ?string
    {
        return $this->breed;
    }

    public function setBreed(?string $breed): Dog
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

    public function getProfileImg(): ?string
    {
        return $this->profileImg;
    }

    public function setProfileImg(?string $profileImg): Dog
    {
        $this->profileImg = $profileImg;

        return $this;
    }

    public function getProfileImgPath(): ?string
    {
        if ($this->profileImg) {
            return self::PROFILE_IMG_PATH.$this->profileImg;
        }

        return self::DEFAULT_PROFILE_IMG_PATH;
    }
}
