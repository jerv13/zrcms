<?php

namespace Zrcms\CoreBlock\Api\Render;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderBlockMissing extends RenderBlock
{
    const OPTION_REASON = 'reason';
    const DEFAULT_REASON = 'MISSING';
}
