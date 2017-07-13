<?php

namespace Zrcms\Core\Container\Api\Render;

use Zrcms\ContentVersionControl\Api\Render\RenderContent;
use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\Core\Container\Model\Container;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderContainer extends RenderContent
{
    /**
     * @param Container|Content $container
     * @param array             $containerRenderData
     * @param array             $options
     *
     * @return string
     */
    public function __invoke(
        Content $container,
        array $containerRenderData,
        array $options = []
    ): string;
}
