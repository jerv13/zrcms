<?php

namespace Zrcms\CoreContainerDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Exception\CmsResourceNotExists;
use Zrcms\Core\Exception\ContentVersionNotExists;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreApplicationDoctrine\Api\CmsResource\UpsertCmsResource;
use Zrcms\CoreContainer\Api\CmsResource\UpsertContainerCmsResource as CoreUpsert;
use Zrcms\CoreContainer\Model\ContainerCmsResource;
use Zrcms\CoreContainer\Model\ContainerCmsResourceBasic;
use Zrcms\CoreContainer\Model\ContainerVersionBasic;
use Zrcms\CoreContainerDoctrine\Entity\ContainerCmsResourceEntity;
use Zrcms\CoreContainerDoctrine\Entity\ContainerCmsResourceHistoryEntity;
use Zrcms\CoreContainerDoctrine\Entity\ContainerVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UpsertContainerCmsResource extends UpsertCmsResource implements CoreUpsert
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
            ContainerCmsResourceEntity::class,
            ContainerCmsResourceHistoryEntity::class,
            ContainerVersionEntity::class,
            ContainerCmsResourceBasic::class,
            ContainerVersionBasic::class,
            []
        );
    }

    /**
     * @param ContainerCmsResource|CmsResource $cmsResource
     * @param string                           $contentVersionId
     * @param string                           $modifiedByUserId
     * @param string                           $modifiedReason
     * @param string|null                      $modifiedDate
     *
     * @return ContainerCmsResource|CmsResource
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
