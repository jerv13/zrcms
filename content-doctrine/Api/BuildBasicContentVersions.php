<?php

namespace Zrcms\ContentDoctrine\Api;

use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildBasicContentVersions
{
    /**
     * @param string $entityClassContentVersion
     * @param string $classContentVersionBasic
     * @param array  $entities
     * @param array  $contentVersionSyncToProperties
     *
     * @return ContentVersion[]
     */
    public static function invoke(
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        array $entities,
        array $contentVersionSyncToProperties = []
    ) {
        $basics = [];

        foreach ($entities as $entity) {
            $basics[] = BuildBasicContentVersion::invoke(
                $entityClassContentVersion,
                $classContentVersionBasic,
                $entity,
                $contentVersionSyncToProperties
            );
        }

        return $basics;
    }

    /**
     * @param string $entityClassContentVersion
     * @param string $classContentVersionBasic
     * @param array  $entities
     * @param array  $contentVersionSyncToProperties
     *
     * @return ContentVersion[]
     */
    public function __invoke(
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        array $entities,
        array $contentVersionSyncToProperties = []
    ) {
        return self::invoke(
            $entityClassContentVersion,
            $classContentVersionBasic,
            $entities,
            $contentVersionSyncToProperties
        );
    }
}
