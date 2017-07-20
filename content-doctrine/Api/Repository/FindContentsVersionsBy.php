<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContentVersionsBy implements \Zrcms\Content\Api\Repository\FindContentVersionsBy
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $contentVersionClass;

    /**
     * @param EntityManager $entityManager
     * @param string        $contentVersionClass
     */
    public function __construct(
        EntityManager $entityManager,
        string $contentVersionClass
    ) {
        $this->entityManager = $entityManager;
        $this->contentVersionClass = $contentVersionClass;
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return array [ContentVersion]
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
            $this->contentVersionClass
        );

        return $repository->findBy(
            $criteria,
            $orderBy,
            $limit,
            $offset
        );
    }
}
