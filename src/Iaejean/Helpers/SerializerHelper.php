<?php
declare(strict_types=1);

namespace Iaejean\Helpers;

use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;

/**
 * Class SerializerHelper
 * @package Iaejean\Helpers
 */
class SerializerHelper
{
    /**
     * @param $object
     * @param SerializationContext|null $context
     * @return string
     */
    public static function toJSON($object, SerializationContext $context = null)
    {
        if ($object instanceof \stdClass) {
            return json_encode($object);
        }

        $jsonSerializationVisitor = new JsonSerializationVisitor(
            new SerializedNameAnnotationStrategy(new IdenticalPropertyNamingStrategy())
        );

        $jsonSerializationVisitor->setOptions(JSON_PRETTY_PRINT);
        $serializerBuilder = SerializerBuilder::create();
        $serializerBuilder->setSerializationVisitor("json", $jsonSerializationVisitor);
        $serializer = $serializerBuilder->build();
        return $serializer->serialize($object, 'json', $context);
    }

    /**
     * @param $json
     * @param string $className
     * @return array|mixed|object
     */
    public static function parseJSON($json, $className = 'stdClass')
    {
        self::validateJSON($json);
        if ($className === 'stdClass') {
            return json_decode($json);
        }

        $serializerBuilder = SerializerBuilder::create();
        $serializerBuilder->setPropertyNamingStrategy(
            new SerializedNameAnnotationStrategy(new IdenticalPropertyNamingStrategy())
        );
        $serializer = $serializerBuilder->build();
        return $serializer->deserialize($json, $className, 'json');
    }

    /**
     * @param $json
     * @return bool
     */
    public static function validateJSON($json)
    {
        json_decode($json);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Deserializing error: '.json_last_error_msg().': '.$json);
        }
        return true;
    }
}
