<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Doctrine\ORM\EntityManager;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindCmsResourcesBy implements \Zrcms\Content\Api\Repository\FindCmsResourcesBy
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $cmsResourceClass;

    /**
     * @param EntityManager $entityManager
     * @param string        $cmsResourceClass
     */
    public function __construct(
        EntityManager $entityManager,
        string $cmsResourceClass
    ) {
        $this->entityManager = $entityManager;
        $this->cmsResourceClass = $cmsResourceClass;
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return array [CmsResource]
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
            $this->cmsResourceClass
        );

        return $repository->findBy(
            $criteria,
            $orderBy,
            $limit,
            $offset
        );
    }
}
