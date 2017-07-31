<?php

namespace Zrcms\Param;

use Zrcms\Param\Exception\IllegalParamException;
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
     * @param array  $params
     * @param string $key
     * @param null   $default
     *
     * @return int|null
     */
    public static function getInt(
        array $params,
        string $key,
        $default = null
    ) {
        if (self::has($params, $key)) {
            return (int)$params[$key];
        }

        return $default;
    }

    /**
     * @param array  $params
     * @param string $key
     * @param null   $default
     *
     * @return string|null
     */
    public static function getString(
        array $params,
        string $key,
        $default = null
    ) {
        if (self::has($params, $key)) {
            return (string)$params[$key];
        }

        return $default;
    }

    /**
     * @param array  $params
     * @param string $key
     * @param null   $default
     *
     * @return array|null
     */
    public static function getArray(
        array $params,
        string $key,
        $default = null
    ) {
        if (self::has($params, $key)) {
            return (array)$params[$key];
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
        self::assertHas($params, $key, $exception);

        return $params[$key];
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

    /**
     * @param array           $params
     * @param string          $key
     * @param \Exception|null $exception
     *
     * @return void
     * @throws ParamMissingException
     * @throws \Exception
     */
    public static function assertHas(
        array $params,
        string $key,
        $exception = null
    ) {
        if (self::has($params, $key)) {
            return;
        }

        if ($exception instanceof \Exception) {
            throw $exception;
        }

        throw new ParamMissingException(
            "Required property ({$key}) is missing and is required"
        );
    }

    /**
     * @param array           $params
     * @param string          $key
     * @param \Exception|null $exception
     *
     * @return void
     * @throws ParamMissingException
     * @throws \Exception
     */
    public static function assertNotHas(
        array $params,
        string $key,
        $exception = null
    ) {
        if (!self::has($params, $key)) {
            return;
        }

        if ($exception instanceof \Exception) {
            throw $exception;
        }

        throw new IllegalParamException(
            "Illegal property ({$key}) is was found"
        );
    }
}
