<?php

namespace Zrcms\CoreThemeDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\CoreApplicationDoctrine\Api\CmsResource\FindCmsResourcesBy;
use Zrcms\CoreTheme\Api\CmsResource\FindLayoutCmsResourcesBy as CoreFindBy;
use Zrcms\CoreTheme\Model\LayoutCmsResource;
use Zrcms\CoreTheme\Model\LayoutCmsResourceBasic;
use Zrcms\CoreTheme\Model\LayoutVersionBasic;
use Zrcms\CoreThemeDoctrine\Entity\LayoutCmsResourceEntity;
use Zrcms\CoreThemeDoctrine\Entity\LayoutVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindLayoutCmsResourcesBy extends FindCmsResourcesBy implements CoreFindBy
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct(
            $entityManager,
            LayoutCmsResourceEntity::class,
            LayoutCmsResourceBasic::class,
            LayoutVersionEntity::class,
            LayoutVersionBasic::class,
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
     * @return LayoutCmsResource[]
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
