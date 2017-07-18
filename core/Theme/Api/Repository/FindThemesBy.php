<?php

namespace Zrcms\Core\Theme\Api\Repository;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindThemesBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null|int   $limit
     * @param null|int   $offset
     * @param array      $options
     *
     * @return array [Theme]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    );
}
