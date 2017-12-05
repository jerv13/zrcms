<?php

namespace Zrcms\Content\Api\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class AssertValidComponentCategory
{
    /**
     * @param string $name
     *
     * @return void
     * @throws \Exception
     */
    public static function invoke(string $name)
    {
        if(strpos($name, '.') !== false) {
            throw new \Exception(
                'Component category can not contain "." for ' . $name
            );
        }
    }

    /**
     * @param string $name
     *
     * @return void
     * @throws \Exception
     */
    public function __invoke(string $name)
    {
        self::invoke($name);
    }
}
