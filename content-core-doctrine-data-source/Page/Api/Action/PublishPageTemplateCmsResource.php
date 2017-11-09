<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Page\Model\PageCmsResourceBasic;
use Zrcms\ContentCore\Page\Model\PageVersionBasic;
use Zrcms\ContentCore\Page\Model\PageTemplateCmsResource;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageVersionEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageTemplateCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageTemplateCmsResourceHistoryEntity;
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
            PageTemplateCmsResourceHistoryEntity::class,
            PageVersionEntity::class,
            PageCmsResourceBasic::class,
            PageVersionBasic::class,
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
