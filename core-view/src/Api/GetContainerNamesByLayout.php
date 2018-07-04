<?php

namespace Zrcms\CoreView\Api;

use Zrcms\CoreTheme\Model\Layout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetContainerNamesByLayout
{
    /**
     * @param Layout $layout
     * @param array  $options
     *
     * @return string[] ['{container-name}']
     */
    public function __invoke(
        Layout $layout,
        array $options = []
    ): array;
}
