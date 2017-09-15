<?php

namespace Zrcms\Content\Api;

use Zrcms\Content\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ComponentToArray
{
    /**
     * @param Component $component
     * @param array     $options
     *
     * @return array
     */
    public function __invoke(
        Component $component,
        array $options = []
    ): array;
}
