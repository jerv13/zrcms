<?php

namespace Zrcms\ContentCore\Block\Api;

use Zrcms\ContentCore\Block\Model\Block;

/**
 *
 */
interface WrapRenderedBlockVersion
{
    /**
     * @param string $innerHtml
     * @param Block  $block
     *
     * @return string
     */
    public function __invoke(string $innerHtml, Block $block): string;
}
