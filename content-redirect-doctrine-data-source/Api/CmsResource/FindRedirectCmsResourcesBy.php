<?php

namespace Zrcms\ContentRedirectDoctrineDataSource\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentDoctrine\Api\CmsResource\FindCmsResourcesBy;
use Zrcms\ContentRedirect\Model\RedirectCmsResource;
use Zrcms\ContentRedirect\Model\RedirectCmsResourceBasic;
use Zrcms\ContentRedirect\Model\RedirectVersionBasic;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectCmsResourceEntity;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindRedirectCmsResourcesBy
    extends FindCmsResourcesBy
    implements \Zrcms\ContentRedirect\Api\CmsResource\FindRedirectCmsResourcesBy
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct(
            $entityManager,
            RedirectCmsResourceEntity::class,
            RedirectCmsResourceBasic::class,
            RedirectVersionEntity::class,
            RedirectVersionBasic::class,
            []
        );
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return RedirectCmsResource[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array
    {
        return parent::__invoke(
            $criteria,
            $orderBy,
            $limit,
            $offset,
            $options
        );
    }
}
