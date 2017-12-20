<?php

namespace Zrcms\Debug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsDebug
{
    protected static $debug = false;
    protected static $isBootstrapped = false;

    /**
     * @param bool $debug
     *
     * @return void
     * @throws \Exception
     */
    public static function bootstrap(bool $debug = false)
    {
        if (self::$isBootstrapped) {
            throw new \Exception(
                'Debug can only be bootstrapped once.'
            );
        }

        self::$debug = $debug;
    }

    /**
     * @return bool
     */
    public static function invoke(): bool
    {
        return self::$debug;
    }

    /**
     * @return bool
     */
    public function __invoke(): bool
    {
        return self::invoke();
    }
}
