<?php

namespace Zrcms\Core\Block\Api;

use Zrcms\Core\Block\Model\Block;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetMergedConfig
{
    /**
     * @param Block $block
     * @param array         $options
     *
     * @return array
     */
    public function __invoke(
        Block $block,
        array $options = []
    ): array;
}
