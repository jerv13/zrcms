<?php

namespace Zrcms\Core\BlockInstance\Api;

use Zrcms\Core\BlockInstance\Model\BlockInstance;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderBlockInstance
{
    /**
     * @param BlockInstance $blockInstance
     * @param array         $options
     *
     * @return string
     */
    public function __invoke(
        BlockInstance $blockInstance,
        array $options = []
    ): string;
}
