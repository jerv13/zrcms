<?php

namespace Zrcms\CoreApplicationDoctrine\Api;

use Zrcms\CoreApplicationDoctrine\Entity\ContentEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ExtractContentVersionEntityProperties
{
    /**
     * @param ContentEntity $entity
     * @param array         $contentVersionSyncToProperties
     *
     * @return array
     * @throws \Exception
     */
    public static function invoke(
        ContentEntity $entity,
        array $contentVersionSyncToProperties
    ) {
        $properties = $entity->getProperties();

        foreach ($contentVersionSyncToProperties as $syncToProperty) {
            $method = 'get' . ucfirst($syncToProperty);
            if (!method_exists($entity, $method)) {
                throw new \Exception(
                    'Can not extract property: ' . $syncToProperty
                    . ' for ' . get_class($entity)
                );
            }

            $properties[$syncToProperty] = $entity->$method();
        }

        return $properties;
    }

    /**
     * @param ContentEntity $entity
     * @param array         $contentVersionSyncToProperties
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        ContentEntity $entity,
        array $contentVersionSyncToProperties
    ) {
        return self::invoke(
            $entity,
            $contentVersionSyncToProperties
        );
    }
}
