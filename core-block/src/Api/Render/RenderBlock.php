<?php

namespace Zrcms\CoreBlock\Api\Render;

use Zrcms\Core\Api\Render\RenderContent;
use Zrcms\Core\Model\Content;
use Zrcms\CoreBlock\Model\Block;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderBlock extends RenderContent
{
    /**
     * @param Block|Content $block
     * @param array         $renderTags ['render-tag' => '{html}']
     * @param array         $options
     *
     * @return string
     */
    public function __invoke(
        Content $block,
        array $renderTags,
        array $options = []
    ): string;
}
