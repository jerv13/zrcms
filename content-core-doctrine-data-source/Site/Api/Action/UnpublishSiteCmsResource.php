<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Site\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteCmsResourcePublishHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteVersionEntity;
use Zrcms\ContentDoctrine\Api\Action\UnpublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UnpublishSiteCmsResource
    extends UnpublishCmsResource
    implements \Zrcms\Content\Api\Action\UnpublishCmsResource
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
            SiteCmsResourcePublishHistoryEntity::class,
            SiteVersionEntity::class
        );
    }

    /**
     * @param SiteCmsResource|CmsResource $siteCmsResource
     * @param string                           $unpublishedByUserId
     * @param string                           $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        CmsResource $siteCmsResource,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool
    {
        return parent::__invoke(
            $siteCmsResource,
            $unpublishedByUserId,
            $unpublishReason
        );
    }
}
