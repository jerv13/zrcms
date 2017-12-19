<?php

namespace Zrcms\Param;

use Zrcms\Debug\IsDebug;
use Zrcms\Param\Exception\IllegalParam;
use Zrcms\Param\Exception\ParamException;
use Zrcms\Param\Exception\ParamMissing;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class Param
{
    protected static function isDebug(): bool
    {
        return IsDebug::invoke();
    }

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
     * @return bool|null
     */
    public static function getBool(
        array $params,
        string $key,
        $default = null
    ) {
        if (self::has($params, $key)) {
            return (bool)$params[$key];
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
     * @throws ParamMissing
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
     * @throws ParamMissing
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
     * @param array  $params
     * @param string $key
     * @param null   $exceptionThrower
     *
     * @return void
     * @throws ParamException
     * @throws ParamMissing
     * @throws \Exception
     * @throws \Throwable
     */
    public static function assertNotEmpty(
        array $params,
        string $key,
        $exceptionThrower = null
    ) {
        self::assertHas(
            $params,
            $key,
            $exceptionThrower
        );

        $value = self::get(
            $params,
            $key,
            null
        );

        if (empty($value)) {
            self::throwParamException(
                $exceptionThrower,
                ParamMissing::class,
                "Property ({$key}) is missing and is required and can not be empty",
                $params
            );
        }
    }

    /**
     * @param array                    $params
     * @param string                   $key
     * @param callable|\Exception|null $exceptionThrower
     *
     * @return void
     * @throws ParamMissing
     * @throws \Exception
     */
    public static function assertHas(
        array $params,
        string $key,
        $exceptionThrower = null
    ) {
        if (self::has($params, $key)) {
            return;
        }

        self::throwParamException(
            $exceptionThrower,
            ParamMissing::class,
            "Property ({$key}) is missing and is required",
            $params
        );
    }

    /**
     * @param array                        $params
     * @param string                       $key
     * @param callable|ParamException|null $exceptionThrower
     *
     * @return void
     * @throws \Throwable
     */
    public static function assertNotHas(
        array $params,
        string $key,
        $exceptionThrower = null
    ) {
        if (!self::has($params, $key)) {
            return;
        }

        self::throwParamException(
            $exceptionThrower,
            IllegalParam::class,
            "Illegal property ({$key}) is was found",
            $params
        );
    }

    /**
     * @param callable|ParamException|null $exceptionThrower
     * @param string                       $defaultParamExceptionClass ParamException ::class
     * @param string                       $defaultMessage
     * @param array                        $params
     *
     * @return void
     * @throws ParamException|\Throwable
     */
    public static function throwParamException(
        $exceptionThrower,
        $defaultParamExceptionClass = ParamException::class,
        $defaultMessage = 'There was an error with a param',
        $params = []
    ) {
        if (is_callable($exceptionThrower)) {
            $exceptionThrower();

            return;
        }

        if (empty($exceptionThrower)) {
            $exceptionThrower = new $defaultParamExceptionClass($defaultMessage);
        }

        if (self::isDebug()) {
            $message = $defaultMessage;

            if (is_a($exceptionThrower, \Throwable::class)) {
                $message = $exceptionThrower->getMessage();
            }

            var_dump(
                "\n<pre>\n"
                . "DEBUG: " . $message . "\n\n"
                . var_export($params, true)
                . "\n</pre>\n"
            );
        }

        if (is_a($exceptionThrower, \Throwable::class)) {
            throw $exceptionThrower;
        }

        die($defaultMessage);
    }
}
