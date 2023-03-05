<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ServiceTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
    #[Assert\NotBlank]
    #[Assert\Length(max: 60)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Service::class)]
    private Collection $services;

    public function __construct()
    {
        $this->services = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): ServiceType
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setType($this);
        }

        return $this;
    }

    public function removeService(Service $service): ServiceType
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getType() === $this) {
                $service->setType(null);
            }
        }

        return $this;
    }
}