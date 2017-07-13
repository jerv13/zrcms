<?php

namespace Zrcms\Core\Layout\Api\Render;

use Zrcms\ContentVersionControl\Api\Render\RenderContent;
use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\Core\Layout\Model\Layout;
use Zrcms\Core\Page\Model\Page;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderLayout extends RenderContent
{
    /**
     * @param Layout|Content $content
     * @param array   $renderData
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
