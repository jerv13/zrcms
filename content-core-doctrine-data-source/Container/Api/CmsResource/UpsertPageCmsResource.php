<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Page\Model\PageCmsResource;
use Zrcms\ContentCore\Page\Model\PageCmsResourceBasic;
use Zrcms\ContentCore\Page\Model\PageVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageCmsResourceHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageVersionEntity;
use Zrcms\ContentDoctrine\Api\CmsResource\UpsertCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UpsertPageCmsResource
    extends UpsertCmsResource
    implements \Zrcms\ContentCore\Page\Api\CmsResource\UpsertPageCmsResource
{
    /**
     * @param EntityManager $entityManager
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
     * @param string                      $modifiedByUserId
     * @param string                      $modifiedReason
     * @param null                        $modifiedDate
     *
     * @return PageCmsResource|CmsResource
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
