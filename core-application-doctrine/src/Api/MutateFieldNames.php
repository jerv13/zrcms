<?php

namespace Zrcms\CoreApplicationDoctrine\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class MutateFieldNames
{
    protected static $map
        = [
            'createdDate' => 'createdDateObject'
        ];

    /**
     * @param array $assocArray
     *
     * @return array
     */
    public static function invoke($assocArray)
    {
        if (empty($assocArray)) {
            return $assocArray;
        }
        $result = [];
        foreach ($assocArray as $key => $value) {
            $result[static::getSubstitutionName($key)] = $value;
        }

        return $result;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public static function getSubstitutionName($key)
    {
        if (array_key_exists($key, static::$map)) {
            return static::$map[$key];
        }

        return $key;
    }
}
