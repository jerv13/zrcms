<?php

namespace Zrcms\CoreSiteContainerDoctrine\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\CoreApplicationDoctrine\Api\Content\FindContentVersionsBy;
use Zrcms\CoreContainer\Model\ContainerVersionBasic;
use Zrcms\CoreSiteContainer\Api\Content\FindSiteContainerVersionsBy as ParentFindBy;
use Zrcms\CoreSiteContainerDoctrine\Entity\SiteContainerVersionEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindSiteContainerVersionsBy extends FindContentVersionsBy implements ParentFindBy
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            SiteContainerVersionEntity::class,
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
