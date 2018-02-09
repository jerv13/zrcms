<?php

namespace Zrcms\CoreApplication\Api\Component;

use Zrcms\Core\Api\Component\ComponentToArray;
use Zrcms\Core\Model\Component;
use Zrcms\CoreApplication\Api\RemoveProperties;
use Reliv\ArrayProperties\Property;

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
        $array = [];

        $array['type'] = $component->getType();
        $array['name'] = $component->getName();
        $array['configUri'] = $component->getConfigUri();
        $array['moduleDirectory'] = $component->getModuleDirectory();
        $array['properties'] = $component->getProperties();
        $array['createdByUserId'] = $component->getCreatedByUserId();
        $array['createdReason'] = $component->getCreatedReason();
        $array['createdDate'] = $component->getCreatedDate();

        return RemoveProperties::invoke(
            $array,
            Property::getArray(
                $options,
                self::OPTION_HIDE_PROPERTIES,
                []
            )
        );
    }
}
