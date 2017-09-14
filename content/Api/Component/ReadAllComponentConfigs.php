<?php

namespace Zrcms\Content\Api\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ReadAllComponentConfigs
{
    /**
     * Return a name spaced list of all component configs
     *
     * @param array $options
     *
     * @return array
     */
    public function __invoke(
        array $options = []
    ): array;
}
