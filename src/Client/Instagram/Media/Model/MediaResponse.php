<?php

declare(strict_types=1);

namespace App\Client\Instagram\Media\Model;

use JMS\Serializer\Annotation as Serializer;
use Serializable;

class MediaResponse implements Serializable
{
    /**
     * @var MediaItem[]|null
     *
     * @Serializer\Expose
     * @Serializer\Type("array<int, App\Client\Instagram\Media\Model\MediaItem>")
     * @Serializer\SerializedName("data")
     */
    public ?array $data = null;

    public function serialize()
    {
        return serialize(['data' => $this->data,]);
    }

    public function unserialize(string $data)
    {
        $unserializedData = unserialize($data);
        $this->data = $unserializedData['data'];
    }

    public function __serialize(): array
    {
        // TODO: Implement __serialize() method.
    }

    public function __unserialize(array $data): void
    {
        // TODO: Implement __unserialize() method.
    }
}
