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

    #[ORM\Column]
    private int $year;

    #[ORM\Column]
    private int $month;

    #[ORM\Column]
    private int $day;

    private ?string $name = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): PublicHoliday
    {
        $this->year = $year;

        return $this;
    }

    public function getMonth(): int
    {
        return $this->month;
    }

    public function setMonth(int $month): PublicHoliday
    {
        $this->month = $month;

        return $this;
    }

    public function getDay(): int
    {
        return $this->day;
    }

    public function setDay(int $day): PublicHoliday
    {
        $this->day = $day;

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
