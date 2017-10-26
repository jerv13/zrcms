<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageCmsResourcePublishHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageVersionEntity;
use Zrcms\ContentDoctrine\Api\Action\UnpublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UnPublishPageCmsResource
    extends UnpublishCmsResource
    implements \Zrcms\ContentCore\Page\Api\Action\UnpublishPageCmsResource
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
            PageCmsResourcePublishHistoryEntity::class,
            PageVersionEntity::class
        );
    }

    /**
     * @param string $pageCmsResourceId
     * @param string $unpublishedByUserId
     * @param string $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        string $pageCmsResourceId,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool
    {
        return parent::__invoke(
            $pageCmsResourceId,
            $unpublishedByUserId,
            $unpublishReason
        );
    }
}
