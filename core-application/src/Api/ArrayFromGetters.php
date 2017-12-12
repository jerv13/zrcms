<?php

namespace Zrcms\CoreApplication\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ArrayFromGetters
{
    /**
     * @param object $object
     * @param array  $hideProperties
     *
     * @return array
     * @throws \Exception
     */
    public static function invoke(
        $object,
        array $hideProperties = []
    ): array {
        if (!is_object($object)) {
            throw new \Exception(
                'Object required'
            );
        }
        $classMethods = get_class_methods($object);

        $array = [];

        foreach ($classMethods as $classMethod) {
            if (substr($classMethod, 0, 3) !== 'get') {
                continue;
            }

            $property = substr($classMethod, 3);
            $property = lcfirst($property);

            if (in_array($property, $hideProperties)) {
                continue;
            }

            $array[$property] = $object->$classMethod();
        }

        return $array;
    }

    /**
     * @param object $object
     * @param array  $hideProperties
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        $object,
        array $hideProperties = []
    ): array {
        return self::invoke(
            $object,
            $hideProperties
        );
    }
}
