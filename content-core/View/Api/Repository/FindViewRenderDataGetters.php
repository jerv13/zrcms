<?php

namespace Zrcms\ContentCore\View\Api\Repository;

use Zrcms\ContentCore\View\Api\Render\GetViewRenderData;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindViewRenderDataGetters
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return GetViewRenderData[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
