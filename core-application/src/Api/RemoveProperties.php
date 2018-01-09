<?php

namespace Zrcms\CoreApplication\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RemoveProperties
{
    /**
     * @param array $properties
     * @param array $list
     *
     * @return array
     */
    public static function invoke(array $properties, array $list)
    {
        foreach ($list as $key) {
            unset($properties[$key]);
        }

        return $properties;
    }

    /**
     * @param array $properties
     * @param array $list
     *
     * @return array
     */
    public function __invoke(array $properties, array $list)
    {
        return static::invoke($properties, $list);
    }
}
