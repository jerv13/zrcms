<?php

namespace Zrcms\Core\BlockInstance\Api;

use Zrcms\Core\BlockInstance\Model\BlockInstance;

interface WrapRenderedBlockInstance
{
    /**
     * @param string        $innerHtml
     * @param BlockInstance $blockInstance
     *
     * @return string
     */
    public function __invoke(string $innerHtml, BlockInstance $blockInstance): string;
}
