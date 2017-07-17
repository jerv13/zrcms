<?php

namespace Zrcms\Core\Page\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\Render\GetContentRenderData;
use Zrcms\Content\Model\Content;
use Zrcms\Core\Page\Model\Page;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetPageRenderData extends GetContentRenderData
{
    /**
     * @param Page|Content           $page
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array ['templateTag' => '{html}']
     */
    public function __invoke(
        Content $page,
        ServerRequestInterface $request,
        array $options = []
    ): array;
}
