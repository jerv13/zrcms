<?php

namespace Zrcms\Core\View\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\View\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewRenderDataHeadLink implements GetViewRenderDataHead
{
    const NAMESPACE = 'link';

    /**
     * @param View|Content       $view
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
            GetViewRenderDataHead::NAMESPACE => [
                self::NAMESPACE => '<!-- @todo: ' . get_class($this) . ' -->'
            ],
        ];
    }
}
