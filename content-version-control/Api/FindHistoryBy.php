<?php

namespace Zrcms\ContentVersionControl\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindHistoryBy extends FindContentBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return array [History]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
