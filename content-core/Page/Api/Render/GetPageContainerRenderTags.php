<?php

namespace Zrcms\ContentCore\Page\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\Render\GetContentRenderTags;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Page\Model\Page;

/**
 * renderDataService
 *
 * @author James Jervis - https://github.com/jerv13
 */
interface GetPageContainerRenderTags extends GetContentRenderTags
{
    /**
     * @param Page|Content $pageContainer
     * @param ServerRequestInterface                $request
     * @param array                                 $options
     *
     * @return string[] ['{render-tag}' => '{html}']
     */
    public function __invoke(
        Content $pageContainer,
        ServerRequestInterface $request,
        array $options = []
    ): array;
}
