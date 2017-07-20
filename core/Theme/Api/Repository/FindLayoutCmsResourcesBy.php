<?php

namespace Zrcms\Core\Theme\Api\Repository;

use Zrcms\Content\Api\Repository\FindCmsResourcesBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLayoutCmsResourcesBy extends FindCmsResourcesBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return array [LayoutCmsResource]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
