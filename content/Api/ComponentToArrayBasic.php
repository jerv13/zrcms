<?php

namespace Zrcms\Content\Api;

use Zrcms\Content\Model\Component;
use Zrcms\Content\Model\PropertiesComponent;

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
     */
    public function __invoke(
        Component $component,
        array $options = []
    ): array
    {
        return [
            PropertiesComponent::NAME
            => $component->getName(),

            PropertiesComponent::NAME_PROPERTIES
            => $component->getProperties()
        ];
    }
}
