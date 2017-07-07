<?php

namespace Zrcms\CoreDoctrine\Page\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\Core\Page\Api\FindPagesPublishedBy;
use Zrcms\CoreDoctrine\Page\Entity\PagePublished;

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
     * @param null|int   $limit
     * @param null|int   $offset
     * @param array      $options
     *
     * @return array [PagePublished]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ) {
        $repository = $this->entityManager->getRepository(PagePublished::class);

        return $repository->findBy($criteria, $orderBy, $limit, $offset);
    }
}
