<?php

namespace Zrcms\CoreBlock\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Render\GetContentRenderTags;
use Zrcms\Core\Model\Content;
use Zrcms\CoreBlock\Model\Block;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetBlockRenderTags extends GetContentRenderTags
{
    /**
     * @param Block|Content          $block
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string[] ['{render-tag}' => '{html}']
     */
    public function __invoke(
        Content $block,
        ServerRequestInterface $request,
        array $options = []
    ): array;
}
