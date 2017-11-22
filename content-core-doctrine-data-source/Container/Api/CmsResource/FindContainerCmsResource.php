<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Container\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Container\Model\ContainerCmsResource;
use Zrcms\ContentCore\Container\Model\ContainerCmsResourceBasic;
use Zrcms\ContentCore\Container\Model\ContainerVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerVersionEntity;
use Zrcms\ContentDoctrine\Api\CmsResource\FindCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContainerCmsResource
    extends FindCmsResource
    implements \Zrcms\ContentCore\Container\Api\CmsResource\FindContainerCmsResource
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
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
     * @param string $id
     * @param array  $options
     *
     * @return ContainerCmsResource|CmsResource|null
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
