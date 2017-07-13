<?php

namespace Zrcms\Core\Layout\Api\Repository;

use Zrcms\ContentVersionControl\Api\Repository\FindContentsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLayoutRenderDataServices extends FindContentsBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return array [GetLayoutRenderData]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
