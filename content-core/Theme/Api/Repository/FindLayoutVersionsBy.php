<?php

namespace Zrcms\ContentCore\Theme\Api\Repository;

use Zrcms\Content\Api\Repository\FindContentVersionsBy;
use Zrcms\ContentCore\Theme\Model\Layout;

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
     * @return Layout[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
