<?php


namespace Zrcms\Core\BlockInstance\Api;


interface WrapRenderedBlockInstance
{
    public function __invoke(string $innerHtml, BlockInstance $blockInstance): string;
}
