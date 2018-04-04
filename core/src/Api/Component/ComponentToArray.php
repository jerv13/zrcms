<?php

namespace Zrcms\Core\Api\Component;

use Zrcms\Core\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ComponentToArray
{
    const OPTION_HIDE_PROPERTIES = 'hideProperties';
    const OPTION_PROPERTIES_OPTIONS = 'propertiesOptions';

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
