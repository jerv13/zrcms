<?php

namespace Zrcms\Core\Api\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ReadComponentConfig
{
    /**
     * @param string $componentConfigLocation (directory or location)
     * @param array  $options
     *
     * @return array
     */
    public function __invoke(
        string $componentConfigLocation,
        array $options = []
    ): array;
}
