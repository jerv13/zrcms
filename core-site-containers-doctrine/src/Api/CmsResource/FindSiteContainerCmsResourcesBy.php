<?php

namespace Zrcms\CoreSiteContainerDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\CoreApplicationDoctrine\Api\CmsResource\FindCmsResourcesBy;
use Zrcms\CoreContainer\Model\ContainerCmsResource;
use Zrcms\CoreContainer\Model\ContainerCmsResourceBasic;
use Zrcms\CoreContainer\Model\ContainerVersionBasic;
use Zrcms\CoreSiteContainer\Api\CmsResource\FindSiteContainerCmsResourcesBy as ParentFindBy;
use Zrcms\CoreSiteContainerDoctrine\Entity\SiteContainerCmsResourceEntity;
use Zrcms\CoreSiteContainerDoctrine\Entity\SiteContainerVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindSiteContainerCmsResourcesBy extends FindCmsResourcesBy implements ParentFindBy
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
            SiteContainerCmsResourceEntity::class,
            ContainerCmsResourceBasic::class,
            SiteContainerVersionEntity::class,
            ContainerVersionBasic::class,
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
     * @return ContainerCmsResource[]
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
