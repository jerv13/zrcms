<?php

namespace Zrcms\File\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\File\Exception\CanNotReadFile;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ReadFile
{
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
    ): string;
}
