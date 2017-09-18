<?php

namespace Zrcms\ContentDoctrine\Api;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Fields\FieldsCmsResource;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildBasicCmsResource
{
    /**
     * @param string                 $entityClassCmsResource
     * @param string                 $classCmsResourceBasic
     * @param string                 $entityClassContentVersion
     * @param string                 $classContentVersionBasic
     * @param CmsResourceEntity|null $entity
     * @param array                  $cmsResourceSyncToProperties
     * @param array                  $contentVersionSyncToProperties
     *
     * @return CmsResource
     * @throws \Exception
     */
    public static function invoke(
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        $entity,
        array $cmsResourceSyncToProperties = [],
        array $contentVersionSyncToProperties = []
    ) {
        if (empty($entity)) {
            return null;
        }

        if (!is_a($entityClassCmsResource, CmsResourceEntity::class, true)) {
            throw new \Exception(
                'Entity class must be of type: ' . CmsResourceEntity::class
            );
        }

        if (!is_a($classCmsResourceBasic, CmsResource::class, true)) {
            throw new \Exception(
                'Class basic must be of type: ' . CmsResource::class
            );
        }

        if (!is_a($entity, $entityClassCmsResource)) {
            throw new \Exception(
                'Entity must be of type: ' . $entityClassCmsResource . ' got: ' . get_class($entity)
            );
        }

        if (!is_a($entity, CmsResourceEntity::class)) {
            throw new \Exception(
                'Entity must be of type: ' . CmsResourceEntity::class . ' got: ' . get_class($entity)
            );
        }

        $properties = ExtractCmsResourceEntityProperties::invoke(
            $entity,
            $cmsResourceSyncToProperties
        );

        $properties[FieldsCmsResource::CONTENT_VERSION] = BuildBasicContentVersion::invoke(
            $entityClassContentVersion,
            $classContentVersionBasic,
            $properties[FieldsCmsResource::CONTENT_VERSION],
            $contentVersionSyncToProperties
        );

        $new = new $classCmsResourceBasic(
            $properties,
            $entity->getCreatedByUserId(),
            $entity->getCreatedReason()
        );

        return $new;
    }

    /**
     * @param string                 $entityClassCmsResource
     * @param string                 $classCmsResourceBasic
     * @param string                 $entityClassContentVersion
     * @param string                 $classContentVersionBasic
     * @param CmsResourceEntity|null $entity
     * @param array                  $cmsResourceSyncToProperties
     * @param array                  $contentVersionSyncToProperties
     *
     * @return CmsResource
     */
    public function __invoke(
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        $entity,
        array $cmsResourceSyncToProperties = [],
        array $contentVersionSyncToProperties = []
    ) {
        return self::invoke(
            $entityClassCmsResource,
            $classCmsResourceBasic,
            $entityClassContentVersion,
            $classContentVersionBasic,
            $entity,
            $cmsResourceSyncToProperties,
            $contentVersionSyncToProperties
        );
    }
}
