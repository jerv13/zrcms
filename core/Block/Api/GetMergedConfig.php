<?php

namespace Zrcms\Core\Block\Api;

use Zrcms\Core\Block\Model\BlockRevision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetMergedConfig
{
    /**
     * @param BlockRevision $blockRevision
     * @param array         $options
     *
     * @return array
     */
    public function __invoke(
        BlockRevision $blockRevision,
        array $options = []
    ): array;
}
