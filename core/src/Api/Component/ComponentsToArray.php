<?php

namespace Zrcms\Core\Api\Component;

use Zrcms\Core\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ComponentsToArray
{
    const OPTION_COMPONENT_OPTIONS = 'component-options';
    const OPTION_HIDE_PROPERTIES = 'hideProperties';

    /**
     * @param Component[] $components
     * @param array       $options
     *
     * @return array
     */
    public function __invoke(
        array $components,
        array $options = []
    ): array;
}
