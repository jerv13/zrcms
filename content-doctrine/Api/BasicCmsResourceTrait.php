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
     * @param string      $entityClassCmsResource
     * @param string      $classCmsResourceBasic
     * @param CmsResource $entity
     *
     * @return CmsResource
     * @throws \Exception
     */
    protected function newBasicCmsResource(
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        $entity
    ) {
        if (empty($entity)) {
            return null;
        }

        if (!is_a($entityClassCmsResource, CmsResource::class, true)) {
            throw new \Exception('Entity class must be of type: ' . CmsResource::class);
        }

        if (!is_a($classCmsResourceBasic, CmsResource::class, true)) {
            throw new \Exception('Entity basic must be of type: ' . CmsResource::class);
        }

        if (!is_a($entity, $entityClassCmsResource)) {
            throw new \Exception('Entity must be of type: ' . $entityClassCmsResource);
        }

        if (!is_a($entity, CmsResource::class)) {
            throw new \Exception('Entity must be of type: ' . CmsResource::class);
        }

        $properties = $entity->getProperties();

        // Sync ID back
        $properties[PropertiesCmsResource::ID] = (string)$entity->getId();

        return new $classCmsResourceBasic(
            $properties,
            $entity->getCreatedByUserId(),
            $entity->getCreatedReason()
        );
    }

    /**
     * @param string $entityClassCmsResource
     * @param string $classCmsResourceBasic
     * @param array  $entities
     *
     * @return array
     */
    protected function newBasicCmsResources(
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        array $entities
    ) {
        $basics = [];

        foreach ($entities as $entity) {
            $basics[] = $this->newBasicCmsResource(
                $entityClassCmsResource,
                $classCmsResourceBasic,
                $entity
            );
        }

        return $basics;
    }
}
