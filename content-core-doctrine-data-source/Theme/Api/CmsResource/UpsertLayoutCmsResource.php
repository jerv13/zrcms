<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentDoctrine\Api\CmsResource\UpsertCmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResourceBasic;
use Zrcms\ContentCore\Theme\Model\LayoutVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutCmsResourceHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UpsertLayoutCmsResource
    extends UpsertCmsResource
    implements \Zrcms\ContentCore\Layout\Api\CmsResource\UpsertLayoutCmsResource
{
    /**
     * @param EntityManager $entityManager
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
     * @param string                          $modifiedByUserId
     * @param string                          $modifiedReason
     * @param null                            $modifiedDate
     *
     * @return LayoutCmsResource|CmsResource
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
