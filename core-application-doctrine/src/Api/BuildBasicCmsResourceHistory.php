<?php

namespace Zrcms\CoreApplicationDoctrine\Api;

use Zrcms\Core\Model\CmsResourceHistory;
use Zrcms\CoreApplicationDoctrine\Entity\CmsResourceHistoryEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildBasicCmsResourceHistory
{
    /**
     * @param string                        $entityClassCmsResourceHistory
     * @param string                        $classCmsResourceHistoryBasic
     * @param string                        $entityClassCmsResource
     * @param string                        $classCmsResourceBasic
     * @param string                        $entityClassContentVersion
     * @param string                        $classContentVersionBasic
     * @param CmsResourceHistoryEntity|null $cmsResourceHistoryEntity
     *
     * @return CmsResourceHistory
     * @throws \Exception
     */
    public static function invoke(
        string $entityClassCmsResourceHistory,
        string $classCmsResourceHistoryBasic,
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        $cmsResourceHistoryEntity
    ) {
        if (empty($cmsResourceHistoryEntity)) {
            return null;
        }

        if (!is_a($entityClassCmsResourceHistory, CmsResourceHistoryEntity::class, true)) {
            throw new \Exception(
                'Entity class must be of type: ' . CmsResourceHistoryEntity::class
            );
        }

        if (!is_a($classCmsResourceHistoryBasic, CmsResourceHistory::class, true)) {
            throw new \Exception(
                'Class basic must be of type: ' . CmsResourceHistory::class
            );
        }

        if (!is_a($cmsResourceHistoryEntity, $entityClassCmsResourceHistory)) {
            throw new \Exception(
                'Entity must be of type: ' . $entityClassCmsResourceHistory
                . ' got: ' . get_class($cmsResourceHistoryEntity)
            );
        }

        if (!is_a($cmsResourceHistoryEntity, CmsResourceHistoryEntity::class)) {
            throw new \Exception(
                'Entity must be of type: ' . CmsResourceHistoryEntity::class
                . ' got: ' . get_class($cmsResourceHistoryEntity)
            );
        }

        $cmsResource = BuildBasicCmsResource::invoke(
            $entityClassCmsResource,
            $classCmsResourceBasic,
            $entityClassContentVersion,
            $classContentVersionBasic,
            $cmsResourceHistoryEntity->getCmsResource(),
            []
        );

        /** @var CmsResourceHistory $new */
        $new = new $classCmsResourceHistoryBasic(
            $cmsResourceHistoryEntity->getId(),
            $cmsResourceHistoryEntity->getAction(),
            $cmsResource,
            $cmsResourceHistoryEntity->getCreatedByUserId(),
            $cmsResourceHistoryEntity->getCreatedReason(),
            $cmsResourceHistoryEntity->getCreatedDate()
        );

        return $new;
    }

    /**
     * @param string                        $entityClassCmsResourceHistory
     * @param string                        $classCmsResourceHistoryBasic
     * @param string                        $entityClassCmsResource
     * @param string                        $classCmsResourceBasic
     * @param string                        $entityClassContentVersion
     * @param string                        $classContentVersionBasic
     * @param CmsResourceHistoryEntity|null $cmsResourceHistoryEntity
     *
     * @return CmsResourceHistory
     * @throws \Exception
     */
    public function __invoke(
        string $entityClassCmsResourceHistory,
        string $classCmsResourceHistoryBasic,
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        $cmsResourceHistoryEntity
    ) {
        return self::invoke(
            $entityClassCmsResourceHistory,
            $classCmsResourceHistoryBasic,
            $entityClassCmsResource,
            $classCmsResourceBasic,
            $entityClassContentVersion,
            $classContentVersionBasic,
            $cmsResourceHistoryEntity
        );
    }
}
