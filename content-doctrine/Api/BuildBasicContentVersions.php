<?php

namespace Zrcms\ContentDoctrine\Api;

use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentDoctrine\Entity\ContentEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildBasicContentVersions
{
    /**
     * @param string          $entityClassContentVersion
     * @param string          $classContentVersionBasic
     * @param ContentEntity[] $contentEntities
     * @param array           $contentVersionSyncToProperties
     *
     * @return ContentVersion[]
     */
    public static function invoke(
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        array $contentEntities,
        array $contentVersionSyncToProperties = []
    ) {
        $basics = [];

        foreach ($contentEntities as $contentEntity) {
            $basics[] = BuildBasicContentVersion::invoke(
                $entityClassContentVersion,
                $classContentVersionBasic,
                $contentEntity,
                $contentVersionSyncToProperties
            );
        }

        return $basics;
    }

    /**
     * @param string          $entityClassContentVersion
     * @param string          $classContentVersionBasic
     * @param ContentEntity[] $contentEntities
     * @param array           $contentVersionSyncToProperties
     *
     * @return ContentVersion[]
     */
    public function __invoke(
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        array $contentEntities,
        array $contentVersionSyncToProperties = []
    ) {
        return self::invoke(
            $entityClassContentVersion,
            $classContentVersionBasic,
            $contentEntities,
            $contentVersionSyncToProperties
        );
    }
}
