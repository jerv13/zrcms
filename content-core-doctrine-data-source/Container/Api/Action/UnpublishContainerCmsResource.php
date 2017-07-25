<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Container\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Container\Model\ContainerCmsResource;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerCmsResourcePublishHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerVersionEntity;
use Zrcms\ContentDoctrine\Api\Action\UnpublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UnpublishContainerCmsResource
    extends UnpublishCmsResource
    implements \Zrcms\Content\Api\Action\UnpublishCmsResource
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
            ContainerCmsResourcePublishHistoryEntity::class,
            ContainerVersionEntity::class
        );
    }

    /**
     * @param ContainerCmsResource|CmsResource $containerCmsResource
     * @param string                           $unpublishedByUserId
     * @param string                           $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        CmsResource $containerCmsResource,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool
    {
        return parent::__invoke(
            $containerCmsResource,
            $unpublishedByUserId,
            $unpublishReason
        );
    }
}
