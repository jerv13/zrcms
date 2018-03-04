<?php

namespace Zrcms\CoreThemeDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Exception\CmsResourceNotExists;
use Zrcms\Core\Exception\ContentVersionNotExists;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreApplicationDoctrine\Api\CmsResource\UpsertCmsResource;
use Zrcms\CoreTheme\Api\CmsResource\UpsertLayoutCmsResource as CoreUpsert;
use Zrcms\CoreTheme\Model\LayoutCmsResource;
use Zrcms\CoreTheme\Model\LayoutCmsResourceBasic;
use Zrcms\CoreTheme\Model\LayoutVersionBasic;
use Zrcms\CoreThemeDoctrine\Entity\LayoutCmsResourceEntity;
use Zrcms\CoreThemeDoctrine\Entity\LayoutCmsResourceHistoryEntity;
use Zrcms\CoreThemeDoctrine\Entity\LayoutVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UpsertLayoutCmsResource extends UpsertCmsResource implements CoreUpsert
{
    /**
     * @param EntityManager $entityManager
     *
     * @throws \Zrcms\CoreApplicationDoctrine\Exception\InvalidEntityException
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            LayoutCmsResourceEntity::class,
            LayoutCmsResourceHistoryEntity::class,
            LayoutVersionEntity::class,
            LayoutCmsResourceBasic::class,
            LayoutVersionBasic::class,
            []
        );
    }

    /**
     * @param LayoutCmsResource|CmsResource $cmsResource
     * @param string                        $contentVersionId
     * @param string                        $modifiedByUserId
     * @param string                        $modifiedReason
     * @param string|null                   $modifiedDate
     *
     * @return LayoutCmsResource|CmsResource
     * @throws CmsResourceNotExists
     * @throws ContentVersionNotExists
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    public function __invoke(
        CmsResource $cmsResource,
        string $contentVersionId,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ): CmsResource {
        return parent::__invoke(
            $cmsResource,
            $contentVersionId,
            $modifiedByUserId,
            $modifiedReason,
            $modifiedDate
        );
    }
}
