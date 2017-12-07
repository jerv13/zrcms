<?php

namespace Zrcms\CoreBlock\Api;

use Zrcms\CoreBlock\Model\Block;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetMergedConfig
{
    /**
     * @param Block $block
     * @param array         $options
     *
     * @return array
     */
    public function __invoke(
        Block $block,
        array $options = []
    ): array;
}
