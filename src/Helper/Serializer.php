<?php

declare(strict_types=1);

namespace App\Helper;

use JMS\Serializer\Accessor\DefaultAccessorStrategy;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\Visitor\Factory\JsonSerializationVisitorFactory;

class Serializer
{
    public const FORMAT_JSON = 'json';
    public const FORMAT_XML = 'xml';

    private static ?SerializerInterface $serializer = null;

    /**
     * @param $data
     * @param $format
     * @param null|SerializationContext $context
     *
     * @return mixed|string
     */
    public static function serialize($data, $format, SerializationContext $context = null)
    {
        if (!$context) {
            $context = new SerializationContext();
        }

        $context->setSerializeNull(true);

        return self::getSerializer()->serialize($data, $format, $context);
    }

    /**
     * @param $data
     * @param $type
     * @param $format
     * @param null|DeserializationContext $context
     *
     * @return mixed
     */
    public static function deserialize($data, $type, $format, DeserializationContext $context = null)
    {
        return self::getSerializer()->deserialize($data, $type, $format, $context);
    }

    /**
     * @return \JMS\Serializer\Serializer
     */
    private static function getSerializer(): SerializerInterface
    {
        if (self::$serializer === null) {
            $propertyNamingStrategy = new SerializedNameAnnotationStrategy(new IdenticalPropertyNamingStrategy());
            $jsonSerializerVisitor = new JsonSerializationVisitorFactory();
            $jsonSerializerVisitor->setOptions(JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION);

            self::$serializer = SerializerBuilder::create()
                ->setPropertyNamingStrategy($propertyNamingStrategy)
                ->setSerializationVisitor(self::FORMAT_JSON, $jsonSerializerVisitor)
                ->setAccessorStrategy(new DefaultAccessorStrategy())
                ->addDefaultDeserializationVisitors()
                ->build();
        }

        return self::$serializer;
    }
}
