<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentCore\Page\Model\PageVersionBasic;
use Zrcms\ContentCoreDoctrineDataSource\Page\Entity\PageVersionEntity;
use Zrcms\ContentDoctrine\Api\Content\FindContentVersionsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPageVersionsBy
    extends FindContentVersionsBy
    implements \Zrcms\ContentCore\Page\Api\Content\FindPageVersionsBy
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            PageVersionEntity::class,
            PageVersionBasic::class
        );
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return PageVersionBasic[]
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
