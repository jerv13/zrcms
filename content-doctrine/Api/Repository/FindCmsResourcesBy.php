<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Zrcms\ContentDoctrine\Api\ApiAbstractCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindCmsResourcesBy
    extends ApiAbstractCmsResource
    implements \Zrcms\Content\Api\Repository\FindCmsResourcesBy
{
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
            $this->entityClass
        );

        return $repository->findBy(
            $criteria,
            $orderBy,
            $limit,
            $offset
        );
    }
}
