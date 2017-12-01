<?php

namespace Zrcms\Content\Api\Component;

/**
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
