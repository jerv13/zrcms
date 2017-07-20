<?php

namespace Zrcms\Core\Block\Api\Repository;

use Zrcms\Content\Api\Repository\FindContentVersionsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindBlockVersionsBy extends FindContentVersionsBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return array [BlockVersion]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
