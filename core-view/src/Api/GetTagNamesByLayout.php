<?php

namespace Zrcms\CoreView\Api;

use Zrcms\CoreTheme\Model\Layout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetTagNamesByLayout
{
    /**
     * @param Layout $layout
     * @param array  $options
     *
     * @return string[] ['{container-path}']
     */
    public function __invoke(
        Layout $layout,
        array $options = []
    ): array;
}
