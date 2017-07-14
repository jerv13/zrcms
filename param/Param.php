<?php

namespace Zrcms\Param;

use Zrcms\Param\Exception\ParamMissingException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class Param
{
    /**
     * @param array  $params
     * @param string $key
     * @param null   $default
     *
     * @return mixed|null
     */
    public static function get(array $params, string $key, $default = null)
    {
        if (self::has($params, $key)) {
            return $params[$key];
        }

        return $default;
    }

    /**
     * @param array  $params
     * @param string $key
     *
     * @return mixed
     * @throws ParamMissingException
     */
    public static function getRequired(array $params, string $key)
    {
        if (!self::has($params, $key)) {
            throw new ParamMissingException(
                "Required property ({$key}) is missing and is required"
            );
        }

        return $params[$key];
    }

    /**
     * @param array  $params
     * @param string $key
     *
     * @return bool
     */
    public static function has(array $params, string $key)
    {
        return array_key_exists($key, $params);
    }
}
