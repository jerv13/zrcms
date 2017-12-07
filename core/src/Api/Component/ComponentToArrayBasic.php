<?php

namespace Zrcms\Core\Api\Component;

use Zrcms\Core\Model\Component;
use Zrcms\Core\Model\TrackableProperties;

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
            'type'
            => $component->getType(),

            'name'
            => $component->getName(),

            'configLocation'
            => $component->getConfigLocation(),

            'properties'
            => $component->getProperties(),

            TrackableProperties::CREATED_BY_USER_ID
            => $component->getCreatedByUserId(),

            TrackableProperties::CREATED_REASON
            => $component->getCreatedReason(),

            TrackableProperties::CREATED_DATE
            => $component->getCreatedDate(),
        ];
    }
}
