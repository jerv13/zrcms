<?php

namespace Zrcms\Core\Block\Api\Repository;

use Zrcms\Content\Api\Repository\FindContentRevisionsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindBlockRevisionsBy extends FindContentRevisionsBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return array [BlockRevision]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
