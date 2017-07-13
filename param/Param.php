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
        if (array_key_exists($key, $params)) {
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
        if (!array_key_exists($key, $params)) {
            throw new ParamMissingException(
                "Required property ({$key}) is missing and is required"
            );
        }

        return $params[$key];
    }
}
