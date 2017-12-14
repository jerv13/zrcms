<?php

namespace Zrcms\CorePageDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CorePage\Model\PageDraftCmsResource;
use Zrcms\CorePage\Model\PageDraftCmsResourceBasic;
use Zrcms\CorePage\Model\PageVersionBasic;
use Zrcms\CorePageDoctrine\Entity\PageDraftCmsResourceEntity;
use Zrcms\CorePageDoctrine\Entity\PageDraftCmsResourceHistoryEntity;
use Zrcms\CorePageDoctrine\Entity\PageVersionEntity;
use Zrcms\CoreApplicationDoctrine\Api\CmsResource\UpsertCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UpsertPageDraftCmsResource extends UpsertCmsResource implements \Zrcms\CorePage\Api\CmsResource\UpsertPageDraftCmsResource
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            PageDraftCmsResourceEntity::class,
            PageDraftCmsResourceHistoryEntity::class,
            PageVersionEntity::class,
            PageDraftCmsResourceBasic::class,
            PageVersionBasic::class,
            []
        );
    }

    /**
     * @param PageDraftCmsResource|CmsResource $cmsResource
     * @param string                              $modifiedByUserId
     * @param string                              $modifiedReason
     * @param null                                $modifiedDate
     *
     * @return PageDraftCmsResource|CmsResource
     */
    public function __invoke(
        CmsResource $cmsResource,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ): CmsResource {
        return parent::__invoke(
            $cmsResource,
            $modifiedByUserId,
            $modifiedReason,
            $modifiedDate
        );
    }
}
