<?php

namespace Zrcms\CoreApplication\Api;

use Zrcms\Core\Api\GetModuleDirectoryFilePath;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetModuleDirectoryFilePathBasic implements GetModuleDirectoryFilePath
{
    /**
     * @param string $moduleDirectory
     * @param string $filePathUri
     * @param string $context
     *
     * @return string
     * @throws \Exception
     */
    public static function invoke(
        string $moduleDirectory,
        string $filePathUri,
        string $context = 'unknown'
    ): string {
        $filePath = parse_url($filePathUri, PHP_URL_PATH);

        $filePath = $moduleDirectory . '/' . $filePath;

        $realFilePath = realpath($filePath);

        if (empty($realFilePath)) {
            throw new \Exception(
                'Path is not valid: ' . $filePathUri
                . ' in: ' . $context
            );
        }

        if (!is_file($realFilePath)) {
            throw new \Exception(
                'File path must be a file: ' . $filePathUri
                . ' in: ' . $context
            );
        }

        return $realFilePath;
    }

    /**
     * @param string $moduleDirectory
     * @param string $filePathUri
     * @param string $context
     *
     * @return string
     * @throws \Exception
     */
    public function __invoke(
        string $moduleDirectory,
        string $filePathUri,
        string $context = 'unknown'
    ): string {
        return static::invoke(
            $moduleDirectory,
            $filePathUri,
            $context
        );
    }
}
