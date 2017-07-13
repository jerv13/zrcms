<?php

namespace Zrcms\ContentVersionControl\Api\Render;

use Zrcms\ContentVersionControl\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderContent
{
    /**
     * @param Content $content
     * @param array   $renderData ['templateTag' => '{html}']
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
