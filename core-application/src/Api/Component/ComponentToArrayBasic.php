<?php

namespace Zrcms\CoreApplication\Api\Component;

use Zrcms\Core\Api\Component\ComponentToArray;
use Zrcms\Core\Model\Component;
use Zrcms\Core\Model\TrackableProperties;
use Zrcms\CoreApplication\Api\ArrayFromGetters;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ComponentToArrayBasic implements ComponentToArray
{
    /**
     * @param Component $component
     * @param array     $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        Component $component,
        array $options = []
    ): array {
        $hideProperties = Param::getArray(
            $options,
            self::OPTION_HIDE_PROPERTIES,
            []
        );

        return ArrayFromGetters::invoke(
            $component,
            $hideProperties
        );
    }
}
