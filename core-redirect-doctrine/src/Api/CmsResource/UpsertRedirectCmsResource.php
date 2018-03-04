<?php

namespace Zrcms\CoreRedirectDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Exception\CmsResourceNotExists;
use Zrcms\Core\Exception\ContentVersionNotExists;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreApplicationDoctrine\Api\CmsResource\UpsertCmsResource;
use Zrcms\CoreRedirect\Api\CmsResource\UpsertRedirectCmsResource as CoreUpsert;
use Zrcms\CoreRedirect\Model\RedirectCmsResource;
use Zrcms\CoreRedirect\Model\RedirectCmsResourceBasic;
use Zrcms\CoreRedirect\Model\RedirectVersionBasic;
use Zrcms\CoreRedirectDoctrine\Entity\RedirectCmsResourceEntity;
use Zrcms\CoreRedirectDoctrine\Entity\RedirectCmsResourceHistoryEntity;
use Zrcms\CoreRedirectDoctrine\Entity\RedirectVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UpsertRedirectCmsResource extends UpsertCmsResource implements CoreUpsert
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
            RedirectCmsResourceEntity::class,
            RedirectCmsResourceHistoryEntity::class,
            RedirectVersionEntity::class,
            RedirectCmsResourceBasic::class,
            RedirectVersionBasic::class,
            []
        );
    }

    /**
     * @param RedirectCmsResource|CmsResource $cmsResource
     * @param string                          $contentVersionId
     * @param string                          $modifiedByUserId
     * @param string                          $modifiedReason
     * @param string|null                     $modifiedDate
     *
     * @return RedirectCmsResource|CmsResource
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
