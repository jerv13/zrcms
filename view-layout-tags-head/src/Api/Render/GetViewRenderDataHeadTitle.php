<?php

namespace Zrcms\ViewLayoutTagsHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\View\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewRenderTagsHeadTitle implements GetViewRenderTagsHead
{
    const RENDER_TAG_TITLE = 'head-title';
    const SERVICE_ALIAS = 'head-title';
    /**
     * @param View|Content           $view
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        Content $view,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        return [
            GetViewRenderTagsHead::RENDER_TAG => [
                self::RENDER_TAG_TITLE => '<!-- @todo: ' . get_class($this) . ' -->'
            ],
        ];
    }
}
