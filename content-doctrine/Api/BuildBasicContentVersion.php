<?php

namespace Zrcms\ContentDoctrine\Api;

use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentDoctrine\Entity\ContentEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildBasicContentVersion
{
    /**
     * @param string             $entityClassContentVersion
     * @param string             $classContentVersionBasic
     * @param ContentEntity|null $entity
     * @param array              $contentVersionSyncToProperties
     *
     * @return ContentVersion|null
     * @throws \Exception
     */
    public static function invoke(
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        $entity,
        array $contentVersionSyncToProperties = []
    ) {
        if (empty($entity)) {
            return null;
        }

        if (!is_a($entityClassContentVersion, ContentEntity::class, true)) {
            throw new \Exception('Entity class must be of type: ' . ContentEntity::class);
        }

        if (!is_a($classContentVersionBasic, ContentVersion::class, true)) {
            throw new \Exception('Class basic must be of type: ' . ContentVersion::class);
        }

        if (!is_a($entity, $entityClassContentVersion)) {
            throw new \Exception('Entity must be of type: ' . $entityClassContentVersion);
        }

        if (!is_a($entity, ContentEntity::class)) {
            throw new \Exception('Entity must be of type: ' . ContentEntity::class);
        }

        $properties = ExtractContentVersionEntityProperties::invoke(
            $entity,
            $contentVersionSyncToProperties
        );

        return new $classContentVersionBasic(
            $properties,
            $entity->getCreatedByUserId(),
            $entity->getCreatedReason()
        );
    }

    /**
     * @param string             $entityClassContentVersion
     * @param string             $classContentVersionBasic
     * @param ContentEntity|null $entity
     * @param array              $contentVersionSyncToProperties
     *
     * @return ContentVersion|null
     * @throws \Exception
     */
    public function __invoke(
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        $entity,
        array $contentVersionSyncToProperties = []
    ) {
        return self::invoke(
            $entityClassContentVersion,
            $classContentVersionBasic,
            $entity,
            $contentVersionSyncToProperties
        );
    }
}
