<?php

namespace Zrcms\CoreSiteContainerDoctrine\Api\CmsResource;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreApplicationDoctrine\Api\CmsResource\FindCmsResource;
use Zrcms\CoreSiteContainer\Api\CmsResource\FindSiteContainerCmsResource as ParentFind;
use Zrcms\CoreContainer\Model\ContainerCmsResource;
use Zrcms\CoreContainer\Model\ContainerCmsResourceBasic;
use Zrcms\CoreContainer\Model\ContainerVersionBasic;
use Zrcms\CoreSiteContainerDoctrine\Entity\SiteContainerCmsResourceEntity;
use Zrcms\CoreSiteContainerDoctrine\Entity\SiteContainerVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindSiteContainerCmsResource extends FindCmsResource implements ParentFind
{
    /**
     * @param EntityManager $entityManager
     *
     * @throws \Zrcms\CoreApplicationDoctrine\Exception\InvalidEntityException
     */
    public function __construct(
        EntityManager $entityManager
    ) {
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
     * @param string $id
     * @param array  $options
     *
     * @return null|CmsResource|ContainerCmsResource
     * @throws \Exception
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
