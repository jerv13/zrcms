<?php

namespace Zrcms\Param;

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
}
