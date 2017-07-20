<?php

namespace Zrcms\Core\Block\Api;

use Zrcms\Core\Block\Model\Block;

/**
 *
 */
interface WrapRenderedBlock
{
    /**
     * @param string $innerHtml
     * @param Block  $block
     *
     * @return string
     */
    public function __invoke(string $innerHtml, Block $block): string;
}
