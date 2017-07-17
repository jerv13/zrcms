<?php

namespace Zrcms\Core\PageView\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\Render\GetContentRenderData;
use Zrcms\Content\Model\Content;
use Zrcms\Core\PageView\Model\PageView;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetPageViewRenderDataHead extends GetContentRenderData
{
    const NAMESPACE = 'head';

    /**
     * @param PageView|Content         $pageView
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     */
    public function __invoke(
        Content $pageView,
        ServerRequestInterface $request,
        array $options = []
    ): array;
}
