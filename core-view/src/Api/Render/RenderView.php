<?php

namespace Zrcms\CoreView\Api\Render;

use Zrcms\Core\Api\Render\RenderContent;
use Zrcms\Core\Model\Content;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderView extends RenderContent
{
    /**
     * @param View|Content $view
     * @param array        $renderTags ['render-tag' => '{html}']
     * @param array        $options
     *
     * @return string
     */
    public function __invoke(
        Content $view,
        array $renderTags,
        array $options = []
    ): string;
}
