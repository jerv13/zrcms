<?php

namespace Zrcms\Core\ThemeLayout\Api\Repository;

use Zrcms\Content\Api\Repository\FindContentsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindThemeLayoutsBy extends FindContentsBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return array [ThemeLayout]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
