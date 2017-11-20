<?php

namespace Zrcms\ContentRedirectDoctrineDataSource\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentDoctrine\Api\CmsResource\UpsertCmsResource;
use Zrcms\ContentRedirect\Model\RedirectCmsResource;
use Zrcms\ContentRedirect\Model\RedirectCmsResourceBasic;
use Zrcms\ContentRedirect\Model\RedirectVersionBasic;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectCmsResourceEntity;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectCmsResourceHistoryEntity;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UpsertRedirectCmsResource
    extends UpsertCmsResource
    implements \Zrcms\ContentRedirect\Api\CmsResource\UpsertRedirectCmsResource
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
            []
        );
    }

    /**
     * @param RedirectCmsResource|CmsResource $cmsResource
     * @param string                          $modifiedByUserId
     * @param string                          $modifiedReason
     * @param null                            $modifiedDate
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $cmsResource,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ): CmsResource
    {
        return parent::__invoke(
            $cmsResource,
            $modifiedByUserId,
            $modifiedReason,
            $modifiedDate
        );
    }
}
