<?php

namespace Zrcms\ContentCore\Page\Api\Render;

use Zrcms\Content\Api\Render\RenderContent;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Page\Model\Page;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderPageContainer extends RenderContent
{
    /**
     * @param Page|Content $pageContainer
     * @param array                                 $renderTags ['render-tag' => '{html}']
     * @param array                                 $options
     *
     * @return string
     */
    public function __invoke(
        Content $pageContainer,
        array $renderTags,
        array $options = []
    ): string;
}
