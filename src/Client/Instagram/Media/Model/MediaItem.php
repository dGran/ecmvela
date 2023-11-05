<?php

declare(strict_types=1);

namespace App\Client\Instagram\Media\Model;

use JMS\Serializer\Annotation as Serializer;

class MediaItem
{
    /**
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("id")
     */
    public ?string $id = null;

    /**
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("caption")
     */
    public ?string $caption = null;

    /**
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("media_type")
     */
    public ?string $mediaType = null;

    /**
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("media_url")
     */
    public ?string $mediaUrl = null;

    /**
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("permalink")
     */
    public ?string $permalink = null;

    /**
     * @Serializer\Expose
     * @Serializer\Type("DateTime")
     * @Serializer\SerializedName("timestamp")
     */
    public ?\DateTime $timestamp = null;
}
