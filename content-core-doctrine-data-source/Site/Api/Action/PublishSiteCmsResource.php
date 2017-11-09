<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Site\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceBasic;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteCmsResourceHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteVersionEntity;
use Zrcms\ContentDoctrine\Api\Action\PublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PublishSiteCmsResource
    extends PublishCmsResource
    implements \Zrcms\ContentCore\Site\Api\Action\PublishSiteCmsResource
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
            [],
            []
        );
    }

    /**
     * @param SiteCmsResource|CmsResource $siteCmsResource
     * @param string                           $publishedByUserId
     * @param string                           $publishReason
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $siteCmsResource,
        string $publishedByUserId,
        string $publishReason
    ): CmsResource
    {
        return parent::__invoke(
            $siteCmsResource,
            $publishedByUserId,
            $publishReason
        );
    }
}
