<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResource;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageContainerCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageContainerCmsResourcePublishHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageContainerVersionEntity;
use Zrcms\ContentDoctrine\Api\Action\UnpublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UnPublishPageContainerCmsResource
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
            PageContainerCmsResourceEntity::class,
            PageContainerCmsResourcePublishHistoryEntity::class,
            PageContainerVersionEntity::class
        );
    }

    /**
     * @param PageContainerCmsResource|CmsResource $pageContainerCmsResource
     * @param string                               $unpublishedByUserId
     * @param string                               $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        CmsResource $pageContainerCmsResource,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool
    {
        return parent::__invoke(
            $pageContainerCmsResource,
            $unpublishedByUserId,
            $unpublishReason
        );
    }
}
