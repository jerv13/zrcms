<?php

namespace Zrcms\Content\Api\Component;

use Zrcms\Content\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindComponentsByCategory
{
    /**
     * @param string $category
     * @param array  $options
     *
     * @return Component[]
     */
    public function __invoke(
        string $category,
        array $options = []
    ): array;
}
