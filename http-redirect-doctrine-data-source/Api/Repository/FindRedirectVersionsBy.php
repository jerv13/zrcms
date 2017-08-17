<?php

namespace Zrcms\HttpRedirectDoctrineDataSource\Redirect\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\HttpRedirect\Redirect\Model\RedirectVersionBasic;
use Zrcms\HttpRedirectDoctrineDataSource\Redirect\Entity\RedirectVersionEntity;
use Zrcms\ContentDoctrine\Api\Repository\FindContentVersionsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindRedirectVersionsBy
    extends FindContentVersionsBy
    implements \Zrcms\HttpRedirect\Redirect\Api\Repository\FindRedirectVersionsBy
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
