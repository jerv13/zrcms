<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Page\Model\PageDraftCmsResource;
use Zrcms\ContentCore\Page\Model\PageDraftCmsResourceBasic;
use Zrcms\ContentCore\Page\Model\PageVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageDraftCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageDraftCmsResourceHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageVersionEntity;
use Zrcms\ContentDoctrine\Api\CmsResource\UpsertCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UpsertPageDraftCmsResource
    extends UpsertCmsResource
    implements \Zrcms\ContentCore\Page\Api\CmsResource\UpsertPageDraftCmsResource
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
