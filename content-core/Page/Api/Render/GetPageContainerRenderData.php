<?php

namespace Zrcms\ContentCore\Page\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\Render\GetContentRenderData;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Page\Model\Page;

/**
 * renderDataService
 *
 * @author James Jervis - https://github.com/jerv13
 */
interface GetPageContainerRenderData extends GetContentRenderData
{
    /**
     * @param Page|Content $pageContainer
     * @param ServerRequestInterface                $request
     * @param array                                 $options
     *
     * @return array ['templateTag' => '{html}']
     */
    public function __invoke(
        Content $pageContainer,
        ServerRequestInterface $request,
        array $options = []
    ): array;
}
