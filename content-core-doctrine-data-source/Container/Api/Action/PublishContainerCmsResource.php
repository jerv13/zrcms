<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Container\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Container\Model\ContainerCmsResource;
use Zrcms\ContentCore\Container\Model\ContainerCmsResourceBasic;
use Zrcms\ContentCore\Container\Model\ContainerVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerCmsResourceHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerVersionEntity;
use Zrcms\ContentDoctrine\Api\Action\PublishCmsResource;

/**
 * @deprecated
 * @author James Jervis - https://github.com/jerv13
 */
class PublishContainerCmsResource
    extends PublishCmsResource
    implements \Zrcms\ContentCore\Container\Api\Action\PublishContainerCmsResource
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
            ContainerVersionEntity::class,
            ContainerCmsResourceBasic::class,
            ContainerVersionBasic::class,
            []
        );
    }

    /**
     * @param ContainerCmsResource|CmsResource $containerCmsResource
     * @param string                           $publishedByUserId
     * @param string                           $publishReason
     * @param string|null                      $publishDate
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $containerCmsResource,
        string $publishedByUserId,
        string $publishReason,
        $publishDate = null
    ): CmsResource {
        // @todo check if published Container of same path and siteCmsResourceId exist before continuing
        return parent::__invoke(
            $containerCmsResource,
            $publishedByUserId,
            $publishReason,
            $publishDate
        );
    }
}
