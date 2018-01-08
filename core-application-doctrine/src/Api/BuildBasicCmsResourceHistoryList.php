<?php

namespace Zrcms\CoreApplicationDoctrine\Api;

use Zrcms\Core\Model\CmsResourceHistory;
use Zrcms\CoreApplicationDoctrine\Entity\CmsResourceHistoryEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildBasicCmsResourceHistoryList
{
    /**
     * @param string                     $entityClassCmsResourceHistory
     * @param string                     $classCmsResourceHistoryBasic
     * @param string                     $entityClassCmsResource
     * @param string                     $classCmsResourceBasic
     * @param string                     $entityClassContentVersion
     * @param string                     $classContentVersionBasic
     * @param CmsResourceHistoryEntity[] $cmsResourceHistoryEntities
     *
     * @return CmsResourceHistory[]
     * @throws \Exception
     */
    public static function invoke(
        string $entityClassCmsResourceHistory,
        string $classCmsResourceHistoryBasic,
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        array $cmsResourceHistoryEntities
    ) {
        $basics = [];

        foreach ($cmsResourceHistoryEntities as $cmsResourceHistoryEntity) {
            $basics[] = BuildBasicCmsResourceHistory::invoke(
                $entityClassCmsResourceHistory,
                $classCmsResourceHistoryBasic,
                $entityClassCmsResource,
                $classCmsResourceBasic,
                $entityClassContentVersion,
                $classContentVersionBasic,
                $cmsResourceHistoryEntity
            );
        }

        return $basics;
    }

    /**
     * @param string $entityClassCmsResourceHistory
     * @param string $classCmsResourceHistoryBasic
     * @param string $entityClassCmsResource
     * @param string $classCmsResourceBasic
     * @param string $entityClassContentVersion
     * @param string $classContentVersionBasic
     * @param array  $cmsResourceHistoryEntities
     *
     * @return CmsResourceHistory[]
     * @throws \Exception
     */
    public function __invoke(
        string $entityClassCmsResourceHistory,
        string $classCmsResourceHistoryBasic,
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        array $cmsResourceHistoryEntities
    ) {
        return self::invoke(
            $entityClassCmsResourceHistory,
            $classCmsResourceHistoryBasic,
            $entityClassCmsResource,
            $classCmsResourceBasic,
            $entityClassContentVersion,
            $classContentVersionBasic,
            $cmsResourceHistoryEntities
        );
    }
}
