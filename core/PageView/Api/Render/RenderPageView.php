<?php

namespace Zrcms\Core\PageView\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\Render\RenderContent;
use Zrcms\Content\Model\Content;
use Zrcms\Core\PageView\Model\PageView;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderPageView extends RenderContent
{
    /**
     * @param PageView|Content       $pageView
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string
     */
    public function __invoke(
        Content $pageView,
        ServerRequestInterface $request,
        array $options = []
    ): string;
}
