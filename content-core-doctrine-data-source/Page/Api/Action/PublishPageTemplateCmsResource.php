<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResourceBasic;
use Zrcms\ContentCore\Page\Model\PageContainerVersionBasic;
use Zrcms\ContentCore\Page\Model\PageTemplateCmsResource;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageContainerVersionEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageTemplateCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageTemplateCmsResourcePublishHistoryEntity;
use Zrcms\ContentDoctrine\Api\Action\PublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PublishPageTemplateCmsResource
    extends PublishCmsResource
    implements \Zrcms\ContentCore\Page\Api\Action\PublishPageTemplateCmsResource
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            PageTemplateCmsResourceEntity::class,
            PageTemplateCmsResourcePublishHistoryEntity::class,
            PageContainerVersionEntity::class,
            PageContainerCmsResourceBasic::class,
            PageContainerVersionBasic::class,
            [],
            []
        );
    }

    /**
     * @param PageTemplateCmsResource|CmsResource $pageTemplateCmsResource
     * @param string                              $publishedByUserId
     * @param string                              $publishReason
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $pageTemplateCmsResource,
        string $publishedByUserId,
        string $publishReason
    ): CmsResource
    {
        return parent::__invoke(
            $pageTemplateCmsResource,
            $publishedByUserId,
            $publishReason
        );
    }
}
