<?php

namespace Zrcms\CoreBlock\Api\Render;

use Zrcms\CoreBlock\Model\Block;

/**
 * @author James Jervis - https://github.com/jerv13
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
