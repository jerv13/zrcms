<?php

namespace Zrcms\CoreApplication\Api\Component;

use Zrcms\Core\Exception\CanNotReadComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class AssertValidReaderProtocol
{
    /**
     * @param string $readerProtocol
     * @param string $componentConfigLocation
     *
     * @return void
     * @throws CanNotReadComponentConfig
     */
    public static function invoke(
        string $readerProtocol,
        string $componentConfigLocation
    ) {
        if (substr($componentConfigLocation, 0, strlen($readerProtocol)) === false) {
            throw new CanNotReadComponentConfig(
                'Protocol (' . $readerProtocol . ') not found in ' . $componentConfigLocation
            );
        }
    }

    /**
     * @param string $readerProtocol
     * @param string $componentConfigLocation
     *
     * @return void
     * @throws CanNotReadComponentConfig
     */
    public function __invoke(
        string $readerProtocol,
        string $componentConfigLocation
    ) {
        self::invoke(
            $readerProtocol,
            $componentConfigLocation
        );
    }
}
