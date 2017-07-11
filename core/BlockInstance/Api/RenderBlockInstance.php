<?php

namespace Zrcms\Core\BlockInstance\Api;

use Zrcms\Core\BlockInstance\Model\BlockInstanceData;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderBlockInstance
{
    /**
     * @param BlockInstanceData $blockInstance
     * @param array             $options
     *
     * @return string
     */
    public function __invoke(
        BlockInstanceData $blockInstance,
        array $options = []
    ): string;
}
