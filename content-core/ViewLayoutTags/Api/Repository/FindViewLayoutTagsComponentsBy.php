<?php

namespace Zrcms\ContentCore\ViewLayoutTags\Api\Repository;

use Zrcms\Content\Api\Repository\FindComponentsBy;
use Zrcms\ContentCore\ViewLayoutTags\Model\ViewLayoutTagsComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindViewLayoutTagsComponentsBy extends FindComponentsBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return ViewLayoutTagsComponent[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
