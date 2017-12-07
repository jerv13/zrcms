<?php

namespace Zrcms\Core\Api\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PrepareComponentConfig
{
    /**
     * @param array $componentConfig
     * @param array $options
     *
     * @return array
     */
    public function __invoke(
        array $componentConfig,
        array $options = []
    ):array;
}
