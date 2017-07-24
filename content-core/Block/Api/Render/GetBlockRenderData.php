<?php

namespace Zrcms\ContentCore\Block\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\Render\GetContentRenderData;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Block\Model\Block;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetBlockRenderData extends GetContentRenderData
{
    /**
     * @param Block|Content          $block
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array ['templateTag' => '{html}']
     */
    public function __invoke(
        Content $block,
        ServerRequestInterface $request,
        array $options = []
    ): array;
}
