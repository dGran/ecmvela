<?php

declare(strict_types=1);

namespace App\Client\Instagram\Model;

use JMS\Serializer\Annotation as Serializer;

class Publications
{
    /**
     * @var Media[]|null
     *
     * @Serializer\Expose
     * @Serializer\Type("array<int, App\Client\Instagram\Model\Media>")
     * @Serializer\SerializedName("data")
     */
    protected ?array $publications = null;

    public function getPublications(): ?array
    {
        return $this->publications;
    }

    public function setPublications(?array $publications): Publications
    {
        $this->publications = $publications;

        return $this;
    }
}
