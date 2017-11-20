<?php

namespace Zrcms\ContentRedirectDoctrineDataSource\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentDoctrine\Api\Action\UnpublishCmsResource;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectCmsResourceEntity;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectCmsResourceHistoryEntity;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectVersionEntity;

/**
 * @deprecated
 * @author James Jervis - https://github.com/jerv13
 */
class UnpublishRedirectCmsResource
    extends UnpublishCmsResource
    implements \Zrcms\ContentRedirect\Api\Action\UnpublishRedirectCmsResource
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
            RedirectVersionEntity::class
        );
    }

    /**
     * @param string      $redirectCmsResourceId
     * @param string      $unpublishedByUserId
     * @param string      $unpublishReason
     * @param string|null $unpublishDate
     *
     * @return bool
     */
    public function __invoke(
        string $redirectCmsResourceId,
        string $unpublishedByUserId,
        string $unpublishReason,
        $unpublishDate = null
    ): bool
    {
        return parent::__invoke(
            $redirectCmsResourceId,
            $unpublishedByUserId,
            $unpublishReason,
            $unpublishDate
        );
    }
}
