<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\View\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutTagsHeadMeta implements GetViewLayoutTagsHead
{
    const RENDER_TAG_META = 'head-meta';
    const SERVICE_ALIAS = 'head-meta';

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
            self::RENDER_TAG_META => '<!-- @todo: ' . get_class($this) . ' -->'
        ];
    }
}
