<?php

namespace Zrcms\ContentCore\Block\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PrepareBlockConfig
{
    /**
     * @param array $blockConfig
     *
     * @return array
     */
    public function __invoke(array $blockConfig): array;
}
