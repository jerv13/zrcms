<?php

namespace Zrcms\CorePage\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Render\GetContentRenderTags;
use Zrcms\Core\Model\Content;
use Zrcms\CorePage\Model\Page;

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
