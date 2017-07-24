<?php

namespace Zrcms\ContentCoreDoctrine\Page\Api;

use Doctrine\ORM\EntityManager;
/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPagePublishedBy implements \Zrcms\ContentCore\Page\Api\FindPagePublishedBy
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
     * @return PagePublished[]
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
