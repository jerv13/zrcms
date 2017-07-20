<?php

namespace Zrcms\Core\Theme\Api\Repository;

use Zrcms\Content\Api\Repository\FindContentVersionsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLayoutVersionsBy extends FindContentVersionsBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return array [Layout]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
