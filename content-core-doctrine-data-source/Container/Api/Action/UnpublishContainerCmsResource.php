<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Container\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerCmsResourceHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerVersionEntity;
use Zrcms\ContentDoctrine\Api\Action\UnpublishCmsResource;

/**
 * @deprecated
 * @author James Jervis - https://github.com/jerv13
 */
class UnpublishContainerCmsResource
    extends UnpublishCmsResource
    implements \Zrcms\ContentCore\Container\Api\Action\UnpublishContainerCmsResource
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
            ContainerCmsResourceHistoryEntity::class,
            ContainerVersionEntity::class
        );
    }

    /**
     * @param string      $containerCmsResourceId
     * @param string      $unpublishedByUserId
     * @param string      $unpublishReason
     * @param string|null $unpublishDate
     *
     * @return bool
     */
    public function __invoke(
        string $containerCmsResourceId,
        string $unpublishedByUserId,
        string $unpublishReason,
        $unpublishDate = null
    ): bool
    {
        return parent::__invoke(
            $containerCmsResourceId,
            $unpublishedByUserId,
            $unpublishReason,
            $unpublishDate
        );
    }
}
