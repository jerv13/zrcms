<?php

namespace Zrcms\CoreContainerDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreContainer\Model\ContainerCmsResource;
use Zrcms\CoreContainer\Model\ContainerCmsResourceBasic;
use Zrcms\CoreContainer\Model\ContainerVersionBasic;
use Zrcms\CoreContainerDoctrine\Entity\ContainerCmsResourceEntity;
use Zrcms\CoreContainerDoctrine\Entity\ContainerVersionEntity;
use Zrcms\CoreApplicationDoctrine\Api\CmsResource\FindCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContainerCmsResource extends FindCmsResource implements \Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResource
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
