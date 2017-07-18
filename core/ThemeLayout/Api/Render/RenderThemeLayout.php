<?php

namespace Zrcms\Core\ThemeLayout\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\Render\RenderContent;
use Zrcms\Content\Model\Content;
use Zrcms\Core\ThemeLayout\Model\ThemeLayout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderThemeLayout extends RenderContent
{
    /**
     * @param ThemeLayout|Content    $themeLayout
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string
     */
    public function __invoke(
        Content $themeLayout,
        ServerRequestInterface $request,
        array $options = []
    ): string;
}
