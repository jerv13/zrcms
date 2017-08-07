<?php

namespace Zrcms\ContentCore\Block\Api\Repository;

use Zrcms\Content\Api\Repository\ReadComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ReadBlockComponentConfig extends ReadComponentConfig
{
    /**
     * @param string $blockLocation
     * @param array  $options
     *
     * @return array
     */
    public function __invoke(
        string $blockLocation,
        array $options = []
    ): array;
}
