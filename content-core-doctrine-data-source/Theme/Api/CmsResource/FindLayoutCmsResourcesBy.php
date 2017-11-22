<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResourceBasic;
use Zrcms\ContentCore\Theme\Model\LayoutVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutVersionEntity;
use Zrcms\ContentDoctrine\Api\CmsResource\FindCmsResourcesBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindLayoutCmsResourcesBy
    extends FindCmsResourcesBy
    implements \Zrcms\ContentCore\Theme\Api\CmsResource\FindLayoutCmsResourcesBy
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
