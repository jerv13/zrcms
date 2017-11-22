<?php

namespace Zrcms\ContentCore\Block\Api\Component;

use Zrcms\Content\Api\Component\FindComponentsBy;
use Zrcms\ContentCore\Block\Model\BlockComponent;

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
     * @return BlockComponent[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
