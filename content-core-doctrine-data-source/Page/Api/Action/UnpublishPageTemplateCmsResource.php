<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Page\Model\PageTemplateCmsResource;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageContainerVersionEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageTemplateCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageTemplateCmsResourcePublishHistoryEntity;
use Zrcms\ContentDoctrine\Api\Action\UnpublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UnpublishPageTemplateCmsResource
    extends UnpublishCmsResource
    implements \Zrcms\ContentCore\Page\Api\Action\UnpublishPageTemplateCmsResource
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
            PageContainerVersionEntity::class
        );
    }

    /**
     * @param string $pageTemplateCmsResourceId
     * @param string $unpublishedByUserId
     * @param string $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        string $pageTemplateCmsResourceId,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool
    {
        return parent::__invoke(
            $pageTemplateCmsResourceId,
            $unpublishedByUserId,
            $unpublishReason
        );
    }
}
