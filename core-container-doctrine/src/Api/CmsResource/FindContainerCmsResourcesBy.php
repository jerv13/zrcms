<?php

namespace Zrcms\CoreContainerDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\CoreApplicationDoctrine\Api\CmsResource\FindCmsResourcesBy;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResourcesBy as CoreFindBy;
use Zrcms\CoreContainer\Model\ContainerCmsResource;
use Zrcms\CoreContainer\Model\ContainerCmsResourceBasic;
use Zrcms\CoreContainer\Model\ContainerVersionBasic;
use Zrcms\CoreContainerDoctrine\Entity\ContainerCmsResourceEntity;
use Zrcms\CoreContainerDoctrine\Entity\ContainerVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContainerCmsResourcesBy extends FindCmsResourcesBy implements CoreFindBy
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct(
            $entityManager,
            ContainerCmsResourceEntity::class,
            ContainerCmsResourceBasic::class,
            ContainerVersionEntity::class,
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
