<?php

namespace Zrcms\ContentDoctrine\Api;

use Zrcms\Content\Model\CmsResourcePublishHistory;
use Zrcms\Content\Model\PropertiesCmsResource;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ExtractCmsResourceEntityProperties
{
    /**
     * @param CmsResourceEntity $entity
     * @param array             $cmsResourceSyncToProperties
     *
     * @return array
     * @throws \Exception
     */
    public static function invoke(
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
                    'Can not extract property: ' . $syncToProperty
                    . ' for ' . get_class($entity)
                );
            }

            $properties[$syncToProperty] = $entity->$method();
        }

        return $properties;
    }

    /**
     * @param CmsResourceEntity $entity
     * @param array             $cmsResourceSyncToProperties
     *
     * @return array
     */
    public function __invoke(
        CmsResourceEntity $entity,
        array $cmsResourceSyncToProperties
    ) {
        return self::invoke(
            $entity,
            $cmsResourceSyncToProperties
        );
    }
}
