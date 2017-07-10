<?php

namespace Zrcms\Core\Block\Api;

use Zrcms\Core\Block\Model\Block;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderBlock
{
    /**
     * Render a block with default data
     *
     * @param Block  $block
     * @param string $tempId
     * @param array  $options
     *
     * @return string
     */
    public function __invoke(
        Block $block,
        string $tempId,
        array $options = []
    ): string;
}
