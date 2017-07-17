<?php

namespace Zrcms\Core\ThemeLayout\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\Render\RenderContent;
use Zrcms\Content\Model\Content;
use Zrcms\Core\ThemeLayout\Model\Layout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderLayout extends RenderContent
{
    /**
     * @param Layout|Content         $layout
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string
     */
    public function __invoke(
        Content $layout,
        ServerRequestInterface $request,
        array $options = []
    ): string;
}
