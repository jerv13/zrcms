<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutCmsResourcePublishHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutVersionEntity;
use Zrcms\ContentDoctrine\Api\Action\UnpublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UnpublishLayoutCmsResource
    extends UnpublishCmsResource
    implements \Zrcms\ContentCore\Layout\Api\Action\UnpublishLayoutCmsResource
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
            LayoutCmsResourcePublishHistoryEntity::class,
            LayoutVersionEntity::class
        );
    }

    /**
     * @param LayoutCmsResource|CmsResource $layoutCmsResource
     * @param string                        $unpublishedByUserId
     * @param string                        $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        CmsResource $layoutCmsResource,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool
    {
        return parent::__invoke(
            $layoutCmsResource,
            $unpublishedByUserId,
            $unpublishReason
        );
    }
}
