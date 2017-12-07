<?php

namespace Zrcms\CoreTheme\Api\Render;

use Zrcms\Core\Api\Render\RenderContent;
use Zrcms\Core\Model\Content;
use Zrcms\CoreTheme\Model\Layout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderLayout extends RenderContent
{
    /**
     * @param Layout|Content $layout
     * @param array          $renderTags ['render-tag' => '{html}']
     * @param array          $options
     *
     * @return string
     */
    public function __invoke(
        Content $layout,
        array $renderTags,
        array $options = []
    ): string;
}
