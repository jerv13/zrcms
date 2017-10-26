<?php

namespace Zrcms\ContentCore\Page\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\Render\GetContentRenderTags;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Page\Model\Page;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetPageRenderTags extends GetContentRenderTags
{
    /**
     * @param Page|Content $page
     * @param ServerRequestInterface                $request
     * @param array                                 $options
     *
     * @return string[] ['{render-tag}' => '{html}']
     */
    public function __invoke(
        Content $page,
        ServerRequestInterface $request,
        array $options = []
    ): array;
}
