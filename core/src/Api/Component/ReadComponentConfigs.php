<?php

namespace Zrcms\Core\Api\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ReadComponentConfigs
{
    /**
     * @param array $options
     *
     * @return array
     */
    public function __invoke(
        array $options = []
    ): array;
}
