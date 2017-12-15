<?php

namespace Zrcms\File\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\File\Exception\CanNotReadFile;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface WriteFile
{
    /**
     * @param ServerRequestInterface $request
     * @param string                 $filePathUri
     * @param string                 $contents
     * @param array                  $options
     *
     * @return string
     * @throws CanNotReadFile
     */
    public function __invoke(
        ServerRequestInterface $request,
        string $filePathUri,
        string $contents,
        array $options = []
    ): string;
}
