<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Block\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCore\Block\Model\BlockVersion;
use Zrcms\ContentCore\Container\Model\Container;
use Zrcms\ContentCore\Container\Model\ContainerVersion;
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

        return $entity->getBlockVersions();
    }
}
