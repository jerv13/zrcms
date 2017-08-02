<?php

namespace Zrcms\ViewRenderDataGetters\Head\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\ContentCore\ViewRenderDataGetter\Api\Render\GetViewRenderData;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetViewRenderDataHead extends GetViewRenderData
{
    const RENDER_TAG = 'head';

    /**
     * @param View|Content         $view
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     */
    public function __invoke(
        Content $view,
        ServerRequestInterface $request,
        array $options = []
    ): array;
}
