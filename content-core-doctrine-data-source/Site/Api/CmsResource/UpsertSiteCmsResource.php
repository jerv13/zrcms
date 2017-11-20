<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Site\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceBasic;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteCmsResourceHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteVersionEntity;
use Zrcms\ContentDoctrine\Api\CmsResource\UpsertCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UpsertSiteCmsResource
    extends UpsertCmsResource
    implements \Zrcms\ContentCore\Site\Api\CmsResource\UpsertSiteCmsResource
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            SiteCmsResourceEntity::class,
            SiteCmsResourceHistoryEntity::class,
            SiteVersionEntity::class,
            SiteCmsResourceBasic::class,
            SiteVersionBasic::class,
            []
        );
    }

    /**
     * @param SiteCmsResource|CmsResource $cmsResource
     * @param string                      $modifiedByUserId
     * @param string                      $modifiedReason
     * @param null                        $modifiedDate
     *
     * @return SiteCmsResource|CmsResource
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
