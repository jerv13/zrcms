<?php

namespace Zrcms\Core\PageView\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\PageView\Model\PageView;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetPageViewRenderDataHeadScript implements GetPageViewRenderDataHead
{
    const NAMESPACE = 'script';

    /**
     * @param PageView|Content       $pageView
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        Content $pageView,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        return [
            GetPageViewRenderDataHead::NAMESPACE => [
                self::NAMESPACE => '<!-- @todo: ' . get_class($this) . ' -->'
            ],
        ];
    }
}
