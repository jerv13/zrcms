<?php

namespace Zrcms\CoreContainerDoctrine\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\CoreContainer\Model\ContainerVersionBasic;
use Zrcms\CoreContainerDoctrine\Entity\ContainerVersionEntity;
use Zrcms\CoreApplicationDoctrine\Api\Content\FindContentVersionsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContainerVersionsBy extends FindContentVersionsBy implements \Zrcms\CoreContainer\Api\Content\FindContainerVersionsBy
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
