<?php

namespace Zrcms\ContentDoctrine\Api;

use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildBasicCmsResources
{
    /**
     * @param string              $entityClassCmsResource
     * @param string              $classCmsResourceBasic
     * @param string              $entityClassContentVersion
     * @param string              $classContentVersionBasic
     * @param CmsResourceEntity[] $cmsResourceEntities
     * @param array               $contentVersionSyncToProperties
     *
     * @return CmsResource[]
     */
    public static function invoke(
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        array $cmsResourceEntities,
        array $contentVersionSyncToProperties = []
    ) {
        $basics = [];

        foreach ($cmsResourceEntities as $cmsResourceEntity) {
            $basics[] = BuildBasicCmsResource::invoke(
                $entityClassCmsResource,
                $classCmsResourceBasic,
                $entityClassContentVersion,
                $classContentVersionBasic,
                $cmsResourceEntity,
                $contentVersionSyncToProperties
            );
        }

        return $basics;
    }

    /**
     * @param string              $entityClassCmsResource
     * @param string              $classCmsResourceBasic
     * @param string              $entityClassContentVersion
     * @param string              $classContentVersionBasic
     * @param CmsResourceEntity[] $cmsResourceEntities
     * @param array               $contentVersionSyncToProperties
     *
     * @return CmsResource[]
     */
    public function __invoke(
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        array $cmsResourceEntities,
        array $contentVersionSyncToProperties = []
    ) {
        return self::invoke(
            $entityClassCmsResource,
            $classCmsResourceBasic,
            $entityClassContentVersion,
            $classContentVersionBasic,
            $cmsResourceEntities,
            $contentVersionSyncToProperties
        );
    }
}
