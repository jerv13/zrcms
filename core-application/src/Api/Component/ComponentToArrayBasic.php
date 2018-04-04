<?php

namespace Zrcms\CoreApplication\Api\Component;

use Reliv\ArrayProperties\Property;
use Zrcms\Core\Api\Component\ComponentToArray;
use Zrcms\Core\Api\PropertiesToArray;
use Zrcms\Core\Model\Component;
use Zrcms\CoreApplication\Api\RemoveProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ComponentToArrayBasic implements ComponentToArray
{
    protected $propertiesToArray;

    /**
     * @param PropertiesToArray $propertiesToArray
     */
    public function __construct(
        PropertiesToArray $propertiesToArray
    ) {
        $this->propertiesToArray = $propertiesToArray;
    }

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
        $array['properties'] = $this->propertiesToArray->__invoke(
            $component->getProperties(),
            Property::getArray(
                $options,
                self::OPTION_PROPERTIES_OPTIONS,
                []
            )
        );
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
