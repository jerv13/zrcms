<?php

namespace Zrcms\ContentCore;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetDomId
{
    protected static $current = 0;

    /**
     * Generate practically unique IDs for use in the dom (per request)
     *
     * @return int
     */
    public static function invoke()
    {
        if (self::$current == PHP_INT_MAX) {
            self::$current = 0;
        }
        self::$current++;

        return self::$current;
    }
}
