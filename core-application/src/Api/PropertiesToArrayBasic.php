<?php

namespace Zrcms\CoreApplication\Api;

use Reliv\ArrayProperties\Property;
use Zrcms\Core\Api\PropertiesToArray;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesToArrayBasic implements PropertiesToArray
{
    /**
     * @param array $properties
     * @param array $options
     *
     * @return array
     */
    public function __invoke(
        array $properties,
        array $options = []
    ): array {
        $clean = [];
        $hide = Property::getArray(
            $options,
            self::OPTION_HIDE_PROPERTIES,
            []
        );
        $showPrivate = Property::getArray(
            $options,
            self::OPTION_SHOW_PRIVATE,
            false
        );
        foreach ($properties as $key => $value) {
            if (!$showPrivate && substr($key, 0, 1) === self::PRIVATE_SUFFIX) {
                continue;
            }

            if (in_array($key, $hide)) {
                continue;
            }

            $clean[$key] = $value;
        }

        return $clean;
    }
}
