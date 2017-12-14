<?php

namespace Zrcms\CoreSiteDoctrine\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\CoreSite\Model\SiteVersionBasic;
use Zrcms\CoreSiteDoctrine\Entity\SiteVersionEntity;
use Zrcms\CoreApplicationDoctrine\Api\Content\FindContentVersionsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindSiteVersionsBy extends FindContentVersionsBy implements \Zrcms\CoreSite\Api\Content\FindSiteVersionsBy
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            SiteVersionEntity::class,
            SiteVersionBasic::class
        );
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return SiteVersionBasic[]
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
