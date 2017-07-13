<?php

namespace Zrcms\Core\Layout\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentVersionControl\Api\Render\GetRenderData;
use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\Core\Layout\Model\Layout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetLayoutRenderData extends GetRenderData
{
    /**
     * @param Layout|Content         $layout
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     */
    public function __invoke(
        Content $layout,
        ServerRequestInterface $request,
        array $options = []
    ): array;
}
