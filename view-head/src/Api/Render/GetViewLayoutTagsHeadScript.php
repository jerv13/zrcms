<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\View\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutTagsHeadScript implements GetViewLayoutTagsHead
{
    const RENDER_TAG_SCRIPT = 'head-script';
    const SERVICE_ALIAS = 'head-script';

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
            self::RENDER_TAG_SCRIPT => '<!-- @todo: ' . get_class($this) . ' -->'
        ];
    }
}
