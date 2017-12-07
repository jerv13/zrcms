<?php

namespace Zrcms\Core\Api\Component;

use Zrcms\Core\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface SearchComponentList
{
    /**
     * @param Component[] $components
     * @param array       $criteria
     *
     * @return array
     */
    public function __invoke(
        array $components,
        array $criteria = []
    ): array;
}
