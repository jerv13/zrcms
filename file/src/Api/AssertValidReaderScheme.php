<?php

namespace Zrcms\File\Api;

use Zrcms\Core\Exception\CanNotReadComponentConfig;
use Zrcms\File\Exception\CanNotReadFile;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class AssertValidReaderScheme
{
    /**
     * @param string $readerScheme
     * @param string $filePathUri
     *
     * @return void
     * @throws CanNotReadFile
     */
    public static function invoke(
        string $readerScheme,
        string $filePathUri
    ) {
        $readerSchemePlus = $readerScheme . ':';
        if (substr($filePathUri, 0, strlen($readerSchemePlus)) !== $readerSchemePlus) {
            throw new CanNotReadFile(
                'Scheme (' . $readerScheme . ') not found in ' . $filePathUri
            );
        }
    }

    /**
     * @param string $readerScheme
     * @param string $filePathUri
     *
     * @return void
     * @throws CanNotReadFile
     */
    public function __invoke(
        string $readerScheme,
        string $filePathUri
    ) {
        self::invoke(
            $readerScheme,
            $filePathUri
        );
    }
}
