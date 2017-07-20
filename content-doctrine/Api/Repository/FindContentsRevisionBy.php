<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContentRevisionsBy implements \Zrcms\Content\Api\Repository\FindContentRevisionsBy
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $contentRevisionClass;

    /**
     * @param EntityManager $entityManager
     * @param string        $contentRevisionClass
     */
    public function __construct(
        EntityManager $entityManager,
        string $contentRevisionClass
    ) {
        $this->entityManager = $entityManager;
        $this->contentRevisionClass = $contentRevisionClass;
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return array [Content]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array
    {
        $repository = $this->entityManager->getRepository(
            $this->contentRevisionClass
        );

        return $repository->findBy(
            $criteria,
            $orderBy,
            $limit,
            $offset
        );
    }
}
