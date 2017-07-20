<?php

namespace Zrcms\Core\Block\Api;

use Zrcms\Core\Block\Model\BlockRevision;

/**
 *
 */
interface WrapRenderedBlockRevision
{
    /**
     * @param string                $innerHtml
     * @param BlockRevision $blockRevision
     *
     * @return string
     */
    public function __invoke(string $innerHtml, BlockRevision $blockRevision): string;
}
