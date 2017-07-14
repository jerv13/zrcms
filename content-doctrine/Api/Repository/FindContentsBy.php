<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContentsBy implements \Zrcms\Content\Api\Repository\FindContentsBy
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $contentClass;

    /**
     * @param EntityManager $entityManager
     * @param string        $contentClass
     */
    public function __construct(
        EntityManager $entityManager,
        string $contentClass
    ) {
        $this->entityManager = $entityManager;
        $this->contentClass = $contentClass;
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
            $this->contentClass
        );

        return $repository->findBy(
            $criteria,
            $orderBy,
            $limit,
            $offset
        );
    }
}
