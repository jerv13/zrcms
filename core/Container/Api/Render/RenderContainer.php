<?php

namespace Zrcms\Core\Container\Api\Render;

use Zrcms\Content\Api\Render\RenderContent;
use Zrcms\Content\Model\Content;
use Zrcms\Core\Container\Model\Container;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderContainer extends RenderContent
{
    /**
     * @param Container|Content $container
     * @param array             $renderData ['templateTag' => '{html}']
     * @param array             $options
     *
     * @return string
     */
    public function __invoke(
        Content $container,
        array $renderData,
        array $options = []
    ): string;
}
