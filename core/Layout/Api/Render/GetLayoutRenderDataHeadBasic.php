<?php

namespace Zrcms\Core\Layout\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\Core\Layout\Model\Layout;

/**
 *
 * @author James Jervis - https://github.com/jerv13
 */
class GetLayoutRenderDataHead implements GetLayoutRenderData
{
    const NAMESPACE = 'head';

    /**
     *
     * @param GetLayoutRenderDataHeadMeta   $getLayoutRenderDataHeadMeta
     * @param GetLayoutRenderDataHeadTitle  $getLayoutRenderDataHeadTitle
     * @param GetLayoutRenderDataHeadLink   $getLayoutRenderDataHeadLink
     * @param GetLayoutRenderDataHeadScript $getLayoutRenderDataHeadScript
     */
    public function __construct(
        GetLayoutRenderDataHeadMeta $getLayoutRenderDataHeadMeta,
        GetLayoutRenderDataHeadTitle $getLayoutRenderDataHeadTitle,
        GetLayoutRenderDataHeadLink $getLayoutRenderDataHeadLink,
        GetLayoutRenderDataHeadScript $getLayoutRenderDataHeadScript
    ) {
        $this->getLayoutRenderDataHeadMeta = $getLayoutRenderDataHeadMeta;
        $this->getLayoutRenderDataHeadTitle = $getLayoutRenderDataHeadTitle;
        $this->getLayoutRenderDataHeadLink = $getLayoutRenderDataHeadLink;
        $this->getLayoutRenderDataHeadScript = $getLayoutRenderDataHeadScript;
    }

    /**
     * @param Layout|Content         $layout
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        Content $layout,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {

    }
}
