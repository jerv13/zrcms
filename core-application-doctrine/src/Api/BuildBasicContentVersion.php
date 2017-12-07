<?php

namespace Zrcms\CoreApplicationDoctrine\Api;

use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreApplicationDoctrine\Entity\ContentEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildBasicContentVersion
{
    /**
     * @param string             $entityClassContentVersion
     * @param string             $classContentVersionBasic
     * @param ContentEntity|null $contentEntity
     * @param array              $contentVersionSyncToProperties
     *
     * @return ContentVersion|null
     * @throws \Exception
     */
    public static function invoke(
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        $contentEntity,
        array $contentVersionSyncToProperties = []
    ) {
        if (empty($contentEntity)) {
            return null;
        }

        if (!is_a($entityClassContentVersion, ContentEntity::class, true)) {
            throw new \Exception('Entity class must be of type: ' . ContentEntity::class);
        }

        if (!is_a($classContentVersionBasic, ContentVersion::class, true)) {
            throw new \Exception('Class basic must be of type: ' . ContentVersion::class);
        }

        if (!is_a($contentEntity, $entityClassContentVersion)) {
            throw new \Exception('Entity must be of type: ' . $entityClassContentVersion);
        }

        if (!is_a($contentEntity, ContentEntity::class)) {
            throw new \Exception('Entity must be of type: ' . ContentEntity::class);
        }

        $properties = ExtractContentVersionEntityProperties::invoke(
            $contentEntity,
            $contentVersionSyncToProperties
        );

        return new $classContentVersionBasic(
            $contentEntity->getId(),
            $properties,
            $contentEntity->getCreatedByUserId(),
            $contentEntity->getCreatedReason(),
            $contentEntity->getCreatedDate()
        );
    }

    /**
     * @param string             $entityClassContentVersion
     * @param string             $classContentVersionBasic
     * @param ContentEntity|null $contentEntity
     * @param array              $contentVersionSyncToProperties
     *
     * @return ContentVersion|null
     * @throws \Exception
     */
    public function __invoke(
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        $contentEntity,
        array $contentVersionSyncToProperties = []
    ) {
        return self::invoke(
            $entityClassContentVersion,
            $classContentVersionBasic,
            $contentEntity,
            $contentVersionSyncToProperties
        );
    }
}
