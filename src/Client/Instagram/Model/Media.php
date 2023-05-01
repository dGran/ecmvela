<?php

declare(strict_types=1);

namespace App\Client\Instagram\Model;

use JMS\Serializer\Annotation as Serializer;

class Media
{
    public const MEDIA_TYPE_IMAGE = 'IMAGE';
    public const MEDIA_TYPE_CAROUSEL_ALBUM = 'CAROUSEL_ALBUM';
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

    /**
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("caption")
     */
    protected ?string $caption = null;

    /**
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("permalink")
     */
    protected ?string $permalink = null;

    /**
     * @Serializer\Expose
     * @Serializer\Type("DateTime")
     * @Serializer\SerializedName("timestamp")
     */
    protected \DateTime $timestamp;

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

    public function getCaption(): ?string
    {
        return $this->caption;
    }

    public function setCaption(?string $caption): void
    {
        $this->caption = $caption;
    }

    public function getPermalink(): ?string
    {
        return $this->permalink;
    }

    public function setPermalink(?string $permalink): void
    {
        $this->permalink = $permalink;
    }

    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTime $timestamp): void
    {
        $this->timestamp = $timestamp;
    }
}