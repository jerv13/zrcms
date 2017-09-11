<?php

namespace Zrcms\ContentDoctrine\Api;

use Zrcms\Content\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildBasicCmsResources
{
    /**
     * @param string $entityClassCmsResource
     * @param string $classCmsResourceBasic
     * @param string $entityClassContentVersion
     * @param string $classContentVersionBasic
     * @param array  $entities
     * @param array  $cmsResourceSyncToProperties
     * @param array  $contentVersionSyncToProperties
     *
     * @return CmsResource[]
     */
    public static function invoke(
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        array $entities,
        array $cmsResourceSyncToProperties = [],
        array $contentVersionSyncToProperties = []
    ) {
        $basics = [];

        foreach ($entities as $entity) {
            $basics[] = BuildBasicCmsResource::invoke(
                $entityClassCmsResource,
                $classCmsResourceBasic,
                $entityClassContentVersion,
                $classContentVersionBasic,
                $entity,
                $cmsResourceSyncToProperties,
                $contentVersionSyncToProperties
            );
        }

        return $basics;
    }

    /**
     * @param string $entityClassCmsResource
     * @param string $classCmsResourceBasic
     * @param string $entityClassContentVersion
     * @param string $classContentVersionBasic
     * @param array  $entities
     * @param array  $cmsResourceSyncToProperties
     * @param array  $contentVersionSyncToProperties
     *
     * @return CmsResource[]
     */
    public function __invoke(
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        array $entities,
        array $cmsResourceSyncToProperties = [],
        array $contentVersionSyncToProperties = []
    ) {
        return self::invoke(
            $entityClassCmsResource,
            $classCmsResourceBasic,
            $entityClassContentVersion,
            $classContentVersionBasic,
            $entities,
            $cmsResourceSyncToProperties,
            $contentVersionSyncToProperties
        );
    }
}
