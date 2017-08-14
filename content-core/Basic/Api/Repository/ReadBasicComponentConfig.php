<?php

namespace Zrcms\ContentCore\Basic\Api\Repository;

use Zrcms\Content\Api\Repository\ReadComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ReadBasicComponentConfig extends ReadComponentConfig
{
    /**
     * @param string $basicLocation
     * @param array  $options
     *
     * @return array
     */
    public function __invoke(
        string $basicLocation,
        array $options = []
    ): array;
}
