<?php

namespace Zrcms\CoreTheme\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Model\Content;
use Zrcms\CoreTheme\Model\Layout;

/**
 * @deprecated NOT NEEDED?
 * @author James Jervis - https://github.com/jerv13
 */
class GetLayoutRenderTagsNoop implements GetLayoutRenderTags
{
    /**
     * @param Layout|Content         $layout
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string[] ['{render-tag}' => '{html}']
     * @throws \Exception
     */
    public function __invoke(
        Content $layout,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        return [];
    }
}
