<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Site\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteCmsResourceHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteVersionEntity;
use Zrcms\ContentDoctrine\Api\Action\UnpublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UnpublishSiteCmsResource
    extends UnpublishCmsResource
    implements \Zrcms\ContentCore\Site\Api\Action\UnpublishSiteCmsResource
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
            SiteVersionEntity::class
        );
    }

    /**
     * @param string $siteCmsResourceId
     * @param string $unpublishedByUserId
     * @param string $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool
    {
        return parent::__invoke(
            $siteCmsResourceId,
            $unpublishedByUserId,
            $unpublishReason
        );
    }
}
