<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResourceBasic;
use Zrcms\ContentCore\Theme\Model\LayoutVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutCmsResourceHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutVersionEntity;
use Zrcms\ContentDoctrine\Api\Action\PublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PublishLayoutCmsResource
    extends PublishCmsResource
    implements \Zrcms\ContentCore\Layout\Api\Action\PublishLayoutCmsResource
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
     * @param LayoutCmsResource|CmsResource $layoutCmsResource
     * @param string                        $publishedByUserId
     * @param string                        $publishReason
     * @param string|null                   $publishDate
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $layoutCmsResource,
        string $publishedByUserId,
        string $publishReason,
        $publishDate = null
    ): CmsResource
    {
        return parent::__invoke(
            $layoutCmsResource,
            $publishedByUserId,
            $publishReason,
            $publishDate
        );
    }
}
