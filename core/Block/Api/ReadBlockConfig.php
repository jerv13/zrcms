<?php

namespace Zrcms\Core\Block\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ReadBlockConfig
{
    /**
     * @param string $blockPath
     * @param array  $options
     *
     * @return array
     */
    public function __invoke(
        string $blockPath,
        array $options = []
    ): array;
}
