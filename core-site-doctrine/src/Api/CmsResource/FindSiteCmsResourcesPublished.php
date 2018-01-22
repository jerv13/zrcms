<?php

namespace Zrcms\CoreSiteDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\CoreApplicationDoctrine\Api\CmsResource\FindCmsResourcesPublished;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourcesPublished as CoreFindPublished ;
use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreSite\Model\SiteCmsResourceBasic;
use Zrcms\CoreSite\Model\SiteVersionBasic;
use Zrcms\CoreSiteDoctrine\Entity\SiteCmsResourceEntity;
use Zrcms\CoreSiteDoctrine\Entity\SiteVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindSiteCmsResourcesPublished extends FindCmsResourcesPublished implements CoreFindPublished
{
    /**
     * @param EntityManager $entityManager
     *
     * @throws \Zrcms\CoreApplicationDoctrine\Exception\InvalidEntityException
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
     * @throws \Exception
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array {
        return parent::__invoke(
            $criteria,
            $orderBy,
            $limit,
            $offset,
            $options
        );
    }
}
