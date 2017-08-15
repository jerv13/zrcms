<?php

namespace Zrcms\XampleComponent\View\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutTags implements \Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags
{
    const XAMPLE_RENDER_TAG = 'xample';

    public function __invoke(
        Content $view,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        return [
            self::XAMPLE_RENDER_TAG => '<b>XAMPLE ViewLayoutTagsGetter</b>'
        ];
    }
}
