<?php

namespace Zrcms\Core\Block\Api\Render;

use Zrcms\Content\Api\Render\RenderContentRevision;
use Zrcms\Content\Model\ContentRevision;
use Zrcms\Core\Block\Model\BlockRevision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderBlockRevision extends RenderContentRevision
{
    /**
     * @param BlockRevision|ContentRevision $blockRevision
     * @param array                                 $renderData ['templateTag' => '{html}']
     * @param array                                 $options
     *
     * @return string
     */
    public function __invoke(
        ContentRevision $blockRevision,
        array $renderData,
        array $options = []
    ): string;
}
