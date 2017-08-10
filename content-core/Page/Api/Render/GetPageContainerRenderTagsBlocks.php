<?php

namespace Zrcms\ContentCore\Page\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Container\Api\Render\GetContainerRenderTagsBlocks;
use Zrcms\ContentCore\Page\Model\Page;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetPageContainerRenderTagsBlocks
    extends GetContainerRenderTagsBlocks
    implements GetPageContainerRenderTags
{
    /**
     * @param Page|Content           $pageContainer
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string[] ['{render-tag}' => '{html}']
     * @throws \Exception
     */
    public function __invoke(
        Content $pageContainer,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        $renderTags =  parent::__invoke(
            $pageContainer,
            $request,
            $options
        );

        return $renderTags;
    }
}
