<?php

namespace Zrcms\ContentCore\Block\Api\Repository;

use Zrcms\Content\Api\Repository\FindComponentsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindBlockComponentsBy extends FindComponentsBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return array [BlockComponent]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
