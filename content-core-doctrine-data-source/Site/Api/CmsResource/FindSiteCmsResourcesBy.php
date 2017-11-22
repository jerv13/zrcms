<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Site\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceBasic;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteVersionEntity;
use Zrcms\ContentDoctrine\Api\CmsResource\FindCmsResourcesBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindSiteCmsResourcesBy
    extends FindCmsResourcesBy
    implements \Zrcms\ContentCore\Site\Api\CmsResource\FindSiteCmsResourcesBy
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct(
            $entityManager,
            SiteCmsResourceEntity::class,
            SiteCmsResourceBasic::class,
            SiteVersionEntity::class,
            SiteVersionBasic::class,
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
     * @return SiteCmsResource[]
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
