<?php

namespace Zrcms\Content\Api\Render;

use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderContent
{
    /**
     * @param Content $content
     * @param array   $renderTags ['render-tag' => '{html}']
     * @param array   $options
     *
     * @return string
     */
    public function __invoke(
        Content $content,
        array $renderTags,
        array $options = []
    ): string;
}
