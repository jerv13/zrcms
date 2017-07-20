<?php

namespace Zrcms\Core\Theme\Api\Render;

use Zrcms\Content\Api\Render\RenderContent;
use Zrcms\Content\Model\Content;
use Zrcms\Core\Theme\Model\Layout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderLayout extends RenderContent
{
    /**
     * @param Layout|Content $layout
     * @param array          $renderData ['templateTag' => '{html}']
     * @param array          $options
     *
     * @return string
     */
    public function __invoke(
        Content $layout,
        array $renderData,
        array $options = []
    ): string;
}
