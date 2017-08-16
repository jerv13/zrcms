<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentCore\View\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderHeadSectionsTag
{
    /**
     * @param View                   $view
     * @param ServerRequestInterface $request
     * @param string                 $tag
     * @param array                  $sections
     * @param array                  $options
     *
     * @return string
     */
    public function __invoke(
        View $view,
        ServerRequestInterface $request,
        string $tag,
        array $sections,
        array $options = []
    ): string;
}
