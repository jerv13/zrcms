<?php

namespace Zrcms\Core\Block\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\Render\GetContentRevisionRenderData;
use Zrcms\Content\Model\ContentRevision;
use Zrcms\Core\Block\Model\BlockRevision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetBlockRevisionRenderData extends GetContentRevisionRenderData
{
    /**
     * @param BlockRevision|ContentRevision $blockRevision
     * @param ServerRequestInterface        $request
     * @param array                         $options
     *
     * @return array ['templateTag' => '{html}']
     */
    public function __invoke(
        ContentRevision $blockRevision,
        ServerRequestInterface $request,
        array $options = []
    ): array;
}
