<?php

namespace Rcms\Core\Page\Api;

use Doctrine\ORM\EntityManager;
use Rcms\Core\Page\Entity\PagePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPagesPublishedEntityBy implements FindPagesPublishedBy
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     *
     * @return array [PagePublished]
     */
    public function __invoke(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $repository = $this->entityManager->getRepository(PagePublished::class);

        return $repository->findBy($criteria, $orderBy, $limit, $offset);
    }
}
