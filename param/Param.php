<?php

namespace Zrcms\Param;

use Zrcms\Param\Exception\IllegalParamException;
use Zrcms\Param\Exception\ParamException;
use Zrcms\Param\Exception\ParamMissingException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class Param
{
    public static $debug = false;

    /**
     * @param array  $params
     * @param string $key
     * @param        $value
     *
     * @return array
     */
    public static function set(
        array $params,
        string $key,
        $value
    ) {
        $params[$key] = $value;

        return $params;
    }

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
     *
     * @return bool
     */
    public static function isEmpty(
        array $params,
        string $key
    ) {
        return empty(self::get($params, $key, null));
    }

    /**
     * @param array  $params
     * @param string $key
     * @param null   $default
     *
     * @return mixed|null
     */
    public static function getDefaultIfEmpty(
        array $params,
        string $key,
        $default = null
    ) {
        if (self::isEmpty($params, $key)) {
            return $default;
        }

        return self::get(
            $params,
            $key,
            $default
        );
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

        self::remove(
            $params,
            $key
        );

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

        self::remove(
            $params,
            $key
        );

        return $value;
    }

    /**
     * @param array  $params
     * @param string $key
     *
     * @return void
     */
    public static function remove(
        array &$params,
        string $key
    ) {
        unset($params[$key]);
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

        if (is_a($exception, \Throwable::class)) {
            self::throwError($exception);
        }

        self::throwError(
            new ParamMissingException(
                "Required property ({$key}) is missing and is required"
            )
        );
    }

    /**
     * @param array  $params
     * @param string $key
     * @param null   $exception
     *
     * @return void
     * @throws IllegalParamException
     * @throws \Throwable
     */
    public static function assertNotHas(
        array $params,
        string $key,
        $exception = null
    ) {
        if (!self::has($params, $key)) {
            return;
        }

        if (is_a($exception, \Throwable::class)) {
            self::throwError($exception);
        }

        self::throwError(
            new IllegalParamException(
                "Illegal property ({$key}) is was found"
            )
        );
    }

    /**
     * @param \Throwable|ParamException $error
     *
     * @return void
     * @throws \Throwable|ParamException
     */
    public static function throwError(\Throwable $error)
    {
        if (self::$debug && is_a($error, ParamException::class)) {
            echo "<pre>\n";
            echo "DEBUG: " . self::class . "\n\n";
            print_r($error->getProperties());
            echo "</pre>\n";
        }

        throw $error;
    }
}
