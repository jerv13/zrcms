<?php

namespace Zrcms\ContentCore\Block\Api\Render;

use Zrcms\Content\Api\Render\RenderContent;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Block\Model\Block;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderBlock extends RenderContent
{
    /**
     * @param Block|Content $block
     * @param array         $renderData ['render-tag' => '{html}']
     * @param array         $options
     *
     * @return string
     */
    public function __invoke(
        Content $block,
        array $renderData,
        array $options = []
    ): string;
}
