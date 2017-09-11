<?php

namespace Zrcms\ContentDoctrine\Api;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourcePublishHistory;
use Zrcms\Content\Model\PropertiesCmsResource;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
trait BasicCmsResourceTrait
{
    use BasicContentVersionTrait;

    /**
     * @param string            $entityClassCmsResource
     * @param string            $classCmsResourceBasic
     * @param string            $entityClassContentVersion
     * @param string            $classContentVersionBasic
     * @param CmsResourceEntity $entity
     * @param array             $cmsResourceSyncToProperties
     * @param array             $contentVersionSyncToProperties
     *
     * @return null
     * @throws \Exception
     */
    protected function newBasicCmsResource(
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
                'Entity class must be of type: ' . CmsResource::class
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

        $properties = $this->syncCmsResourceProperties(
            $entity,
            $cmsResourceSyncToProperties
        );

        $properties[PropertiesCmsResource::CONTENT_VERSION] = $this->newBasicContentVersion(
            $entityClassContentVersion,
            $classContentVersionBasic,
            $properties[PropertiesCmsResource::CONTENT_VERSION],
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
     * @param CmsResourceEntity $entity
     * @param array             $cmsResourceSyncToProperties
     *
     * @return CmsResource[]
     * @throws \Exception
     */
    protected function syncCmsResourceProperties(
        CmsResourceEntity $entity,
        array $cmsResourceSyncToProperties
    ) {
        // always sync
        if (!array_key_exists(PropertiesCmsResource::ID, $cmsResourceSyncToProperties)) {
            $cmsResourceSyncToProperties[] = PropertiesCmsResource::ID;
        }

        if (!array_key_exists(PropertiesCmsResource::CONTENT_VERSION, $cmsResourceSyncToProperties)) {
            $cmsResourceSyncToProperties[] = PropertiesCmsResource::CONTENT_VERSION;
        }

        // @todo This is for publish only - needs to have it's own sync
        if (is_a($entity, CmsResourcePublishHistory::class)
            && !array_key_exists(
                PropertiesCmsResource::PUBLISHED,
                $cmsResourceSyncToProperties
            )
        ) {
            $cmsResourceSyncToProperties[] = PropertiesCmsResource::PUBLISHED;
        }

        $properties = $entity->getProperties();

        foreach ($cmsResourceSyncToProperties as $syncToProperty) {
            $method = 'get' . ucfirst($syncToProperty);
            if (!method_exists($entity, $method)) {
                throw new \Exception(
                    'Can not sync property: ' . $syncToProperty
                    . ' for ' . get_class($entity)
                );
            }

            $properties[$syncToProperty] = $entity->$method();
        }

        return $properties;
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
    protected function newBasicCmsResources(
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
            $basics[] = $this->newBasicCmsResource(
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
}
