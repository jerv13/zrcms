<?php

namespace Zrcms\ContentRedirectDoctrineDataSource\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentRedirect\Model\RedirectCmsResource;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectCmsResourceEntity;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectCmsResourcePublishHistoryEntity;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectVersionEntity;
use Zrcms\ContentDoctrine\Api\Action\UnpublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UnpublishRedirectCmsResource
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
            RedirectCmsResourceEntity::class,
            RedirectCmsResourcePublishHistoryEntity::class,
            RedirectVersionEntity::class
        );
    }

    /**
     * @param RedirectCmsResource|CmsResource $redirectCmsResource
     * @param string                           $unpublishedByUserId
     * @param string                           $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        CmsResource $redirectCmsResource,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool
    {
        return parent::__invoke(
            $redirectCmsResource,
            $unpublishedByUserId,
            $unpublishReason
        );
    }
}
