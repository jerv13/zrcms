<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResourceBasic;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutCmsResourceEntity;
use Zrcms\ContentDoctrine\Api\Repository\FindCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindLayoutCmsResource
    extends FindCmsResource
    implements \Zrcms\Content\Api\Repository\FindCmsResource
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
            LayoutCmsResourceBasic::class
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