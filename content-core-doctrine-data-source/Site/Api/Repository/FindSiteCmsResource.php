<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Site\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResourceBasic;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteVersionEntity;
use Zrcms\ContentDoctrine\Api\Repository\FindCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindSiteCmsResource
    extends FindCmsResource
    implements \Zrcms\ContentCore\Site\Api\Repository\FindSiteCmsResource
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            SiteCmsResourceEntity::class,
            SiteCmsResourceBasic::class,
            SiteVersionEntity::class,
            SiteVersionBasic::class,
            [],
            []
        );
    }

    /**
     * @param string $id
     * @param array  $options
     *
     * @return SiteCmsResource|CmsResource|null
     */
    public function __invoke(
        string $id,
        array $options = []
    ) {
        return parent::__invoke(
            $id,
            $options
        );
    }
}
