<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Block\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCore\Block\Model\BlockVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Block\Entity\BlockVersionEntity;
use Zrcms\ContentDoctrine\Api\Repository\FindContentVersionsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindBlockVersionsBy
    extends FindContentVersionsBy
    implements \Zrcms\ContentCore\Block\Api\Repository\FindBlockVersionsBy
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            BlockVersionEntity::class
        );
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return BlockVersionBasic[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array
    {
        throw new \Exception('not implemented');
        return parent::__invoke(
            $criteria,
            $orderBy,
            $limit,
            $offset,
            $options
        );
    }
}
