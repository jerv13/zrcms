<?php

namespace Zrcms\ContentDoctrine\Api;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\PropertiesCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
trait BasicCmsResourceTrait
{
    /**
     * @param string           $entityClassCmsResource
     * @param string           $classCmsResourceBasic
     * @param CmsResource|null $entity
     * @param array            $cmsResourceSyncToProperties
     *
     * @return CmsResource|null
     * @throws \Exception
     */
    protected function newBasicCmsResource(
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        $entity,
        array $cmsResourceSyncToProperties = []
    ) {
        if (empty($entity)) {
            return null;
        }

        if (!is_a($entityClassCmsResource, CmsResource::class, true)) {
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

        if (!is_a($entity, CmsResource::class)) {
            throw new \Exception(
                'Entity must be of type: ' . CmsResource::class . ' got: ' . get_class($entity)
            );
        }

        $properties = $this->syncCmsResourceProperties(
            $entity,
            $cmsResourceSyncToProperties
        );

        return new $classCmsResourceBasic(
            $properties,
            $entity->getCreatedByUserId(),
            $entity->getCreatedReason()
        );
    }

    /**
     * @param CmsResource $entity
     * @param array       $cmsResourceSyncToProperties
     *
     * @return CmsResource[]
     * @throws \Exception
     */
    protected function syncCmsResourceProperties(
        CmsResource $entity,
        array $cmsResourceSyncToProperties
    ) {
        // always sync
        if (!array_key_exists(PropertiesCmsResource::ID, $cmsResourceSyncToProperties)) {
            $contentVersionSyncToProperties[] = PropertiesCmsResource::ID;
        }

        if (!array_key_exists(PropertiesCmsResource::CONTENT_VERSION_ID, $cmsResourceSyncToProperties)) {
            $contentVersionSyncToProperties[] = PropertiesCmsResource::CONTENT_VERSION_ID;
        }

        if (!array_key_exists(PropertiesCmsResource::PUBLISHED, $cmsResourceSyncToProperties)) {
            $contentVersionSyncToProperties[] = PropertiesCmsResource::PUBLISHED;
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
     * @param array  $entities
     * @param array  $cmsResourceSyncToProperties
     *
     * @return CmsResource[]
     */
    protected function newBasicCmsResources(
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        array $entities,
        array $cmsResourceSyncToProperties = []
    ) {
        $basics = [];

        foreach ($entities as $entity) {
            $basics[] = $this->newBasicCmsResource(
                $entityClassCmsResource,
                $classCmsResourceBasic,
                $entity,
                $cmsResourceSyncToProperties
            );
        }

        return $basics;
    }
}
