<?php

namespace Zrcms\ContentRedirectDoctrineDataSource\Api\Content;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentRedirect\Model\RedirectVersionBasic;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectVersionEntity;
use Zrcms\ContentDoctrine\Api\Content\FindContentVersionsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindRedirectVersionsBy
    extends FindContentVersionsBy
    implements \Zrcms\ContentRedirect\Api\Content\FindRedirectVersionsBy
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            RedirectVersionEntity::class,
            RedirectVersionBasic::class
        );
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return RedirectVersionBasic[]
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
