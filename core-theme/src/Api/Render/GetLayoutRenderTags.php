<?php

namespace Zrcms\CoreTheme\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Render\GetContentRenderTags;
use Zrcms\Core\Model\Content;
use Zrcms\CoreTheme\Model\Layout;

/**
 * @deprecated NOT NEEDED?
 * @author James Jervis - https://github.com/jerv13
 */
interface GetLayoutRenderTags extends GetContentRenderTags
{
    /**
     * @param Layout|Content         $layout
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string[] ['{render-tag}' => '{html}']
     */
    public function __invoke(
        Content $layout,
        ServerRequestInterface $request,
        array $options = []
    ): array;
}
