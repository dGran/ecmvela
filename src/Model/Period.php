<?php

declare(strict_types=1);

namespace App\Model;

class Period
{
    private \DateTime $startDate;
    private \DateTime $endDate;
    private string $type;

    public function __construct(\DateTime $startDate, \DateTime $endDate, string $type)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->type = $type;
    }

    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
