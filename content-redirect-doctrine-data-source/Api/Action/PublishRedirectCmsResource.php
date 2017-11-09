<?php

namespace Zrcms\ContentRedirectDoctrineDataSource\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentRedirect\Model\RedirectCmsResource;
use Zrcms\ContentRedirect\Model\RedirectCmsResourceBasic;
use Zrcms\ContentRedirect\Model\RedirectVersionBasic;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectCmsResourceEntity;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectCmsResourceHistoryEntity;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectVersionEntity;
use Zrcms\ContentDoctrine\Api\Action\PublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PublishRedirectCmsResource
    extends PublishCmsResource
    implements \Zrcms\ContentRedirect\Api\Action\PublishRedirectCmsResource
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
            RedirectCmsResourceHistoryEntity::class,
            RedirectVersionEntity::class,
            RedirectCmsResourceBasic::class,
            RedirectVersionBasic::class,
            [],
            []
        );
    }

    /**
     * @param RedirectCmsResource|CmsResource $redirectCmsResource
     * @param string                           $publishedByUserId
     * @param string                           $publishReason
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $redirectCmsResource,
        string $publishedByUserId,
        string $publishReason
    ): CmsResource
    {
        return parent::__invoke(
            $redirectCmsResource,
            $publishedByUserId,
            $publishReason
        );
    }
}
