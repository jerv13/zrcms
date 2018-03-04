<?php

namespace Zrcms\CorePageDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Exception\CmsResourceNotExists;
use Zrcms\Core\Exception\ContentVersionNotExists;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CorePage\Model\PageCmsResource;
use Zrcms\CorePage\Model\PageCmsResourceBasic;
use Zrcms\CorePage\Model\PageVersionBasic;
use Zrcms\CorePageDoctrine\Entity\PageCmsResourceEntity;
use Zrcms\CorePageDoctrine\Entity\PageCmsResourceHistoryEntity;
use Zrcms\CorePageDoctrine\Entity\PageVersionEntity;
use Zrcms\CoreApplicationDoctrine\Api\CmsResource\UpsertCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UpsertPageCmsResource extends UpsertCmsResource implements \Zrcms\CorePage\Api\CmsResource\UpsertPageCmsResource
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
            PageCmsResourceEntity::class,
            PageCmsResourceHistoryEntity::class,
            PageVersionEntity::class,
            PageCmsResourceBasic::class,
            PageVersionBasic::class,
            []
        );
    }

    /**
     * @param PageCmsResource|CmsResource $cmsResource
     * @param string                           $contentVersionId
     * @param string                           $modifiedByUserId
     * @param string                           $modifiedReason
     * @param string|null                      $modifiedDate
     *
     * @return PageCmsResource|CmsResource
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
