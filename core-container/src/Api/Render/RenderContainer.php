<?php

namespace Zrcms\CoreContainer\Api\Render;

use Zrcms\Core\Api\Render\RenderContent;
use Zrcms\Core\Model\Content;
use Zrcms\CoreContainer\Model\Container;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderContainer extends RenderContent
{
    /**
     * @param Container|Content $container
     * @param array             $renderTags ['render-tag' => '{html}']
     * @param array             $options
     *
     * @return string
     */
    public function __invoke(
        Content $container,
        array $renderTags,
        array $options = []
    ): string;
}
