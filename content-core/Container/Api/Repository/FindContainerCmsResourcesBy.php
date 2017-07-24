<?php

namespace Zrcms\ContentCore\Container\Api\Repository;

use Zrcms\Content\Api\Repository\FindCmsResourcesBy;
use Zrcms\ContentCore\Container\Model\ContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindContainerCmsResourcesBy extends FindCmsResourcesBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return ContainerCmsResource[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
