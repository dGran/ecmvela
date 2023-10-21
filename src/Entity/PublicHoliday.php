<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PublicHolidayRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PublicHolidayRepository::class)]
class PublicHoliday
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(unique: true)]
    private \DateTime $date;

    #[ORM\Column]
    private ?string $name = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): PublicHoliday
    {
        $this->date = $date;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): PublicHoliday
    {
        $this->name = $name;

        return $this;
    }
}
