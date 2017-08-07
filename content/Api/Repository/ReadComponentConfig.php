<?php

namespace Zrcms\Content\Api\Repository;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ReadComponentConfig
{
    /**
     * @param string $location (directory or location)
     * @param array  $options
     *
     * @return array
     */
    public function __invoke(
        string $location,
        array $options = []
    ): array;
}
