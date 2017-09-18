<?php

namespace Zrcms\ContentDoctrine\Api;

use Zrcms\Content\Model\CmsResourcePublishHistory;
use Zrcms\Content\Fields\FieldsCmsResource;
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
        if (!array_key_exists(FieldsCmsResource::ID, $cmsResourceSyncToProperties)) {
            $cmsResourceSyncToProperties[] = FieldsCmsResource::ID;
        }

        if (!array_key_exists(FieldsCmsResource::CONTENT_VERSION, $cmsResourceSyncToProperties)) {
            $cmsResourceSyncToProperties[] = FieldsCmsResource::CONTENT_VERSION;
        }

        // @todo This is for publish only - needs to have it's own sync
        if (is_a($entity, CmsResourcePublishHistory::class)
            && !array_key_exists(
                FieldsCmsResource::PUBLISHED,
                $cmsResourceSyncToProperties
            )
        ) {
            $cmsResourceSyncToProperties[] = FieldsCmsResource::PUBLISHED;
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
