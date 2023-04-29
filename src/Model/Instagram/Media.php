<?php

declare(strict_types=1);

namespace App\Model\Instagram;

use JMS\Serializer\Annotation as Serializer;

class Media
{
    public const MEDIA_TYPE_IMAGE = 'IMAGE';
    public const MEDIA_TYPE_VIDEO = 'VIDEO';

    /**
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("media_type")
     */
    protected ?string $mediaType = null;

    /**
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("media_url")
     */
    protected ?string $mediaURL = null;

    public function getMediaType(): ?string
    {
        return $this->mediaType;
    }

    public function setMediaType(?string $mediaType): Media
    {
        $this->mediaType = $mediaType;

        return $this;
    }

    public function getMediaURL(): ?string
    {
        return $this->mediaURL;
    }

    public function setMediaURL(?string $mediaURL): Media
    {
        $this->mediaURL = $mediaURL;

        return $this;
    }
}