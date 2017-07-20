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
    public static function get(
        array $params,
        string $key,
        $default = null
    ) {
        if (self::has($params, $key)) {
            return $params[$key];
        }

        return $default;
    }

    /**
     * @param array           $params
     * @param string          $key
     * @param \Exception|null $exception
     *
     * @return mixed
     * @throws ParamMissingException
     * @throws \Exception
     */
    public static function getRequired(
        array $params,
        string $key,
        $exception = null
    ) {
        if (self::has($params, $key)) {
            return $params[$key];
        }

        $messageParams['key'] = $key;

        if ($exception instanceof \Exception) {
            throw $exception;
        }

        throw new ParamMissingException(
            "Required property ({$key}) is missing and is required"
        );
    }

    /**
     * @param array  $params
     * @param string $key
     *
     * @return bool
     */
    public static function has(
        array $params,
        string $key
    ) {
        return array_key_exists($key, $params);
    }

    /**
     * @param array  $params
     * @param string $key
     * @param null   $default
     *
     * @return mixed|null
     */
    public static function getAndRemove(
        array &$params,
        string $key,
        $default = null
    ) {
        $value = self::get(
            $params,
            $key,
            $default
        );

        unset($params[$key]);

        return $value;
    }

    /**
     * @param array  $params
     * @param string $key
     * @param null   $exception
     *
     * @return mixed
     * @throws ParamMissingException
     * @throws \Exception
     */
    public static function getAndRemoveRequired(
        array &$params,
        string $key,
        $exception = null
    ) {
        $value = self::getRequired(
            $params,
            $key,
            $exception
        );

        unset($params[$key]);

        return $value;
    }
}
