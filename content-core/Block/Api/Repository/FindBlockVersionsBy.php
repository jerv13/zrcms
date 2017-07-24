<?php

namespace Zrcms\ContentCore\Block\Api\Repository;

use Zrcms\Content\Api\Repository\FindContentVersionsBy;
use Zrcms\ContentCore\Block\Model\BlockVersion;

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
     * @return BlockVersion[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
