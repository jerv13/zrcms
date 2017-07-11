<?php

namespace Zrcms\CoreConfigDataSource\Block\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ReadBlockConfig
{
    /**
     * @param string $blockDirectory
     * @param array  $options
     *
     * @return array
     */
    public function __invoke(
        string $blockDirectory,
        array $options = []
    ): array;
}
