<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Container\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCore\Container\Model\ContainerVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerVersionEntity;
use Zrcms\ContentDoctrine\Api\Content\FindContentVersionsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContainerVersionsBy
    extends FindContentVersionsBy
    implements \Zrcms\ContentCore\Container\Api\Content\FindContainerVersionsBy
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            ContainerVersionEntity::class,
            ContainerVersionBasic::class
        );
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return ContainerVersionBasic[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array
    {
        return parent::__invoke(
            $criteria,
            $orderBy,
            $limit,
            $offset,
            $options
        );
    }
}
