<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ServiceTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceTypeRepository::class)]
class ServiceType
{
    protected const SERVICE_TYPE_BASIC_HYGIENE_ID = 1;
    protected const SERVICE_TYPE_TECHNIQUE_AND_ARRANGEMENT_ID = 2;
    protected const SERVICE_TYPE_TREATMENTS_ID = 3;
    protected const SERVICE_TYPE_COSMETIC_ID = 4;

    protected const SERVICE_TYPE_BASIC_HYGIENE_NAME = 'Higiene básica';
    protected const SERVICE_TYPE_TECHNIQUE_AND_ARRANGEMENT_NAME = 'Técnica y arreglo';
    protected const SERVICE_TYPE_TREATMENTS_NAME = 'Tratamientos';
    protected const SERVICE_TYPE_COSMETIC_NAME = 'Cosmética';

    #[ORM\Id]
    #[ORM\GeneratedValue('AUTO')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $name = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ServiceType
    {
        $this->name = $name;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}