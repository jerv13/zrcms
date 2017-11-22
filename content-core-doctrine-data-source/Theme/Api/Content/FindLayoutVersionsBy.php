<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCore\Theme\Model\LayoutVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutVersionEntity;
use Zrcms\ContentDoctrine\Api\Content\FindContentVersionsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindLayoutVersionsBy
    extends FindContentVersionsBy
    implements \Zrcms\ContentCore\Theme\Api\Content\FindLayoutVersionsBy
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            LayoutVersionEntity::class,
            LayoutVersionBasic::class
        );
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return LayoutVersionBasic[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array {
        return parent::__invoke(
            $criteria,
            $orderBy,
            $limit,
            $offset,
            $options
        );
    }
}
