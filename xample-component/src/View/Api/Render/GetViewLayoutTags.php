<?php

namespace Zrcms\XampleComponent\View\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutTags implements \Zrcms\CoreView\Api\Render\GetViewLayoutTags
{
    const XAMPLE_RENDER_TAG = 'xample';

    /**
     * @param Content                $view
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     */
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
