<?php

namespace Zrcms\Locale\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DefaultLocal
{
    protected static $defaultLocal = 'en_US';
    protected static $hasBeenSet = false;

    /**
     * Allows set on bootstrap and may only be set once
     *
     * @param string $defaultLocal
     *
     * @return void
     * @throws \Exception
     */
    public static function set(string $defaultLocal)
    {
        if (self::$hasBeenSet) {
            throw new \Exception(
                'Default locale may only be set once'
            );
        }
        self::$defaultLocal = $defaultLocal;
        self::$hasBeenSet = true;
    }

    /**
     * @return string
     */
    public static function get()
    {
        return self::$defaultLocal;
    }
}
