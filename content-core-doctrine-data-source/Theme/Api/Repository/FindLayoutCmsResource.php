<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResourceBasic;
use Zrcms\ContentCore\Theme\Model\LayoutVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutVersionEntity;
use Zrcms\ContentDoctrine\Api\Repository\FindCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindLayoutCmsResource
    extends FindCmsResource
    implements \Zrcms\ContentCore\Theme\Api\Repository\FindLayoutCmsResource
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            LayoutCmsResourceEntity::class,
            LayoutCmsResourceBasic::class,
            LayoutVersionEntity::class,
            LayoutVersionBasic::class,
            [],
            []
        );
    }

    /**
     * @param string $id
     * @param array  $options
     *
     * @return LayoutCmsResource|CmsResource|null
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
