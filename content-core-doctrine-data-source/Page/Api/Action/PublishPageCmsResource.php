<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Page\Model\PageCmsResource;
use Zrcms\ContentCore\Page\Model\PageCmsResourceBasic;
use Zrcms\ContentCore\Page\Model\PageVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageCmsResourcePublishHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageVersionEntity;
use Zrcms\ContentDoctrine\Api\Action\PublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PublishPageCmsResource
    extends PublishCmsResource
    implements \Zrcms\ContentCore\Page\Api\Action\PublishPageCmsResource
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
            PageVersionEntity::class,
            PageCmsResourceBasic::class,
            PageVersionBasic::class,
            [],
            []
        );
    }

    /**
     * @param PageCmsResource|CmsResource $pageCmsResource
     * @param string                      $publishedByUserId
     * @param string                      $publishReason
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $pageCmsResource,
        string $publishedByUserId,
        string $publishReason
    ): CmsResource
    {
        return parent::__invoke(
            $pageCmsResource,
            $publishedByUserId,
            $publishReason
        );
    }
}
