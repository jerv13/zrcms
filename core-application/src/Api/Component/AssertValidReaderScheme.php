<?php

namespace Zrcms\CoreApplication\Api\Component;

use Zrcms\Core\Exception\CanNotReadComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class AssertValidReaderScheme
{
    /**
     * @param string $readerScheme
     * @param string $componentConfigUri
     *
     * @return void
     * @throws CanNotReadComponentConfig
     */
    public static function invoke(
        string $readerScheme,
        string $componentConfigUri
    ) {
        $readerSchemePlus = $readerScheme . ':';
        if (substr($componentConfigUri, 0, strlen($readerSchemePlus)) !== $readerSchemePlus) {
            throw new CanNotReadComponentConfig(
                'Scheme (' . $readerScheme . ') not found in ' . $componentConfigUri
            );
        }
    }

    /**
     * @param string $readerScheme
     * @param string $componentConfigUri
     *
     * @return void
     * @throws CanNotReadComponentConfig
     */
    public function __invoke(
        string $readerScheme,
        string $componentConfigUri
    ) {
        self::invoke(
            $readerScheme,
            $componentConfigUri
        );
    }
}
