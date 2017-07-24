<?php

namespace Zrcms\ContentCore\Page\Api\Repository;

use Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResourcesBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindPageContainerCmsResourcesBy extends FindContainerCmsResourcesBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null|int   $limit
     * @param null|int   $offset
     * @param array      $options
     *
     * @return array [PageContainerCmsResource]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
