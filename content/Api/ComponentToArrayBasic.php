<?php

namespace Zrcms\Content\Api;

use Zrcms\Content\Model\Component;
use Zrcms\Content\Fields\FieldsComponent;

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
            FieldsComponent::NAME
            => $component->getName(),

            FieldsComponent::NAME_PROPERTIES
            => $component->getProperties()
        ];
    }
}
