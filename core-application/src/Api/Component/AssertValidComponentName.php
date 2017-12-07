<?php

namespace Zrcms\CoreApplication\Api\Component;

/**
 * @todo NOT USED?
 *
 * @author James Jervis - https://github.com/jerv13
 */
class AssertValidComponentName
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
                'Component name can not contain "." for ' . $name
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
