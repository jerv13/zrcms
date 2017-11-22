<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Site\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Site\Entity\SiteVersionEntity;
use Zrcms\ContentDoctrine\Api\Content\FindContentVersionsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindSiteVersionsBy
    extends FindContentVersionsBy
    implements \Zrcms\ContentCore\Site\Api\Content\FindSiteVersionsBy
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
