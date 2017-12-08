<?php

namespace Zrcms\Core\Api\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface SearchComponentConfigs
{
    /**
     * @param array $componentConfigs
     * @param array $criteria
     *
     * @return array
     */
    public function __invoke(
        array $componentConfigs,
        array $criteria = []
    ):array;
}
