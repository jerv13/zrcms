<?php

namespace Zrcms\ContentCore\Block\Api;

use Zrcms\Content\Api\ReadComponentConfig;

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
