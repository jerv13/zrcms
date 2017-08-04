<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Block\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCore\Block\Model\BlockVersion;
use Zrcms\ContentCore\Container\Model\Container;
use Zrcms\ContentCore\Container\Model\ContainerVersion;
use Zrcms\ContentCoreDoctrineDataSource\Block\Model\BlockVersionEntity;
use Zrcms\ContentCoreDoctrineDataSource\Block\Model\PropertiesBlockVersionEntity;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindBlockVersionsByContainer
    implements \Zrcms\ContentCore\Block\Api\Repository\FindBlockVersionsByContainer
{
    /**
     * @var
     */
    protected $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Container|ContainerVersion $container
     * @param array                      $options
     *
     * @return BlockVersion[]
     */
    public function __invoke(
        Container $container,
        array $options = []
    ): array
    {
        $repository = $this->entityManager->getRepository(ContainerVersionEntity::class);

        /** @var ContainerVersionEntity $entity */
        $entity = $repository->find(
            $container->getId()
        );

        return $this->buildBlockVersions($entity);
    }

    /**
     * @param ContainerVersionEntity $entity
     *
     * @return array
     */
    protected function buildBlockVersions($entity): array
    {
        if (empty($entity)) {
            return [];
        }

        $blockVersions = $entity->getBlockVersions();

        $blockVersionEntities = [];

        foreach ($blockVersions as $blockVersion) {
            $blockVersionEntities[] = $this->buildBlockVersion(
                $entity,
                $blockVersion
            );
        }

        return $blockVersionEntities;
    }

    /**
     * @param ContainerVersionEntity $entity
     * @param array                  $blockVersion
     *
     * @return BlockVersion
     */
    protected function buildBlockVersion(
        ContainerVersionEntity $entity,
        array $blockVersion
    ): BlockVersion
    {
        // We map the IDs to this object since that are one-to-one
        $blockVersion[PropertiesBlockVersionEntity::ID] = $entity->getId();
        $blockVersion[PropertiesBlockVersionEntity::BLOCK_CONTAINER_CMS_RESOURCE_ID] = $entity->getId();
        $blockVersion[PropertiesBlockVersionEntity::CREATED_DATE] = $entity->getCreatedDate();

        return new BlockVersionEntity(
            $blockVersion,
            $entity->getCreatedByUserId(),
            $entity->getCreatedReason()
        );
    }
}
