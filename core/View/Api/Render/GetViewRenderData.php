<?php

namespace Zrcms\Core\View\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\Render\GetContentRenderData;
use Zrcms\Content\Model\Content;
use Zrcms\Core\View\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetViewRenderData extends GetContentRenderData
{
    /**
     * @param View|Content           $view
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array ['templateTag' => '{html}']
     */
    public function __invoke(
        Content $view,
        ServerRequestInterface $request,
        array $options = []
    ): array;
}
