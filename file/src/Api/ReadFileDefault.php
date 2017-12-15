<?php

namespace Zrcms\File\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\File\Exception\CanNotReadFile;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadFileDefault implements ReadFile
{
    const SERVICE_ALIAS = 'default';
    const READER_SCHEME = 'default';

    /**
     * @param ServerRequestInterface $request
     * @param string                 $filePathUri
     * @param array                  $options
     *
     * @return string
     * @throws CanNotReadFile
     */
    public function __invoke(
        ServerRequestInterface $request,
        string $filePathUri,
        array $options = []
    ): string {
        $scheme = parse_url($filePathUri, PHP_URL_SCHEME);
        if ($scheme !== static::READER_SCHEME && !empty($scheme)) {
            throw new CanNotReadFile('Path URI is not valid for this reader: ' . $filePathUri);
        }

        $filePath = parse_url($filePathUri, PHP_URL_PATH);

        $realFilePath = realpath($filePath);

        if (empty($realFilePath)) {
            throw new CanNotReadFile('Path is not valid: ' . $filePath);
        }

        if (!is_file($realFilePath)) {
            throw new CanNotReadFile('File path must be a file: ' . $filePath);
        }

        return file_get_contents($realFilePath);
    }
}
