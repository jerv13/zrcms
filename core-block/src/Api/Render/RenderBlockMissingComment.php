<?php

namespace Zrcms\CoreBlock\Api\Render;

use Zrcms\Core\Model\Content;
use Zrcms\CoreBlock\Model\Block;

/**
 * Component is missing or has been removed, use this renderer
 *
 * @author James Jervis - https://github.com/jerv13
 */
class RenderBlockMissingComment implements RenderBlockMissing
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
    ): string {
        return "\n"
        . '<!-- BLOCK COMPONENT MISSING: '
        . $block->getBlockComponentName()
        . ' for block: ' . $block->getId()
        . '-->'
        . "\n";
    }
}
