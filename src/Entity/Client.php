<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    public const TYPE_INSTAGRAM = 1;

    public const NAME_INSTAGRAM = 'instagram';

    public const ACCESS_1_NAME_INSTAGRAM = 'client_id';

    public const ACCESS_2_NAME_INSTAGRAM = 'client_secret';

    public const ACCESS_3_NAME_INSTAGRAM = 'redirect_uri';

    public const ACCESS_4_NAME_INSTAGRAM = 'access_token';

    public const ACCESS_5_NAME_INSTAGRAM = 'expires_in';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $access1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $access2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $access3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $access4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $access5 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $access6 = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateExpiration = null;

    #[ORM\Column]
    private bool $valid = false;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): Client
    {
        $this->name = $name;

        return $this;
    }

    public function getAccess1(): ?string
    {
        return $this->access1;
    }

    public function setAccess1(?string $access1): Client
    {
        $this->access1 = $access1;

        return $this;
    }

    public function getAccess2(): ?string
    {
        return $this->access2;
    }

    public function setAccess2(?string $access2): Client
    {
        $this->access2 = $access2;

        return $this;
    }

    public function getAccess3(): ?string
    {
        return $this->access3;
    }

    public function setAccess3(?string $access3): Client
    {
        $this->access3 = $access3;

        return $this;
    }

    public function getAccess4(): ?string
    {
        return $this->access4;
    }

    public function setAccess4(?string $access4): Client
    {
        $this->access4 = $access4;

        return $this;
    }

    public function getAccess5(): ?string
    {
        return $this->access5;
    }

    public function setAccess5(?string $access5): Client
    {
        $this->access5 = $access5;

        return $this;
    }

    public function getAccess6(): ?string
    {
        return $this->access6;
    }

    public function setAccess6(?string $access6): Client
    {
        $this->access6 = $access6;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(?\DateTimeInterface $dateExpiration): Client
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function setValid(bool $valid): Client
    {
        $this->valid = $valid;

        return $this;
    }
}
