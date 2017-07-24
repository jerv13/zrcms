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
     * @param array   $renderData ['render-tag' => '{html}']
     * @param array   $options
     *
     * @return string
     */
    public function __invoke(
        Content $content,
        array $renderData,
        array $options = []
    ): string;
}
