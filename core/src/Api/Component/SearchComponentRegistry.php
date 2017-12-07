<?php

namespace Zrcms\Core\Api\Component;

/**
 * @todo NOT USED?
 * @author James Jervis - https://github.com/jerv13
 */
interface SearchComponentRegistry
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
