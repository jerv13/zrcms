<?php

namespace Zrcms\ContentCore\Page\Api\Render;

use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Container\Api\Render\RenderContainerRows;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderPageContainerRows extends RenderContainerRows implements RenderPageContainer
{
    /**
     * @param Content $pageContainer
     * @param array   $renderTags
     * @param array   $options
     *
     * @return string
     */
    public function __invoke(
        Content $pageContainer,
        array $renderTags,
        array $options = []
    ): string
    {
        $options['containerType'] = 'pageContainer';

        return parent::__invoke(
            $pageContainer,
            $renderTags,
            $options
        );
    }
}
