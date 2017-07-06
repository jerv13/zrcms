<?php

namespace Rcms\Core\Page\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Find
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     *
     * @return array [PagePublished]
     */
    public function __invoke(array $criteria, array $orderBy = null, $limit = null, $offset = null);
}
