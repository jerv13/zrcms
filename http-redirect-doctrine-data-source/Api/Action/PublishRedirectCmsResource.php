<?php

namespace Zrcms\HttpRedirectDoctrineDataSource\Redirect\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\HttpRedirect\Redirect\Model\RedirectCmsResource;
use Zrcms\HttpRedirect\Redirect\Model\RedirectCmsResourceBasic;
use Zrcms\HttpRedirectDoctrineDataSource\Redirect\Entity\RedirectCmsResourceEntity;
use Zrcms\HttpRedirectDoctrineDataSource\Redirect\Entity\RedirectCmsResourcePublishHistoryEntity;
use Zrcms\HttpRedirectDoctrineDataSource\Redirect\Entity\RedirectVersionEntity;
use Zrcms\ContentDoctrine\Api\Action\PublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PublishRedirectCmsResource
    extends PublishCmsResource
    implements \Zrcms\HttpRedirect\Redirect\Api\Action\PublishRedirectCmsResource
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
            RedirectVersionEntity::class,
            RedirectCmsResourceBasic::class
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
